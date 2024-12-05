<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectAssign;
use App\Models\ProjectModule;
use App\Models\ProjectModuleDetail;
use Illuminate\Http\Request;

class ModuleController extends Controller
{   

    public function index()
    {
        // $modules = ProjectModule::with('project', 'details.assignProject.user')->get();
        $modules = ProjectModule::get();
        return view('admin.module.index', compact('modules'));
    }

    public function empList(Request $request)
    {

    $request->validate([
        'project_id' => 'required|exists:projects,id',
    ]);

    // Retrieve the project_id from the request
    $projectId = $request->project_id;
    dd($projectId);
    // Fetch the list of users assigned to the project
    $assignedEmployees = ProjectAssign::with('employee')
        ->where('project_id', $projectId)
        ->get();

    // Check if any employees are assigned
    if ($assignedEmployees->isEmpty()) {
        return response()->json([
            'success' => true,
            'message' => 'No employees are assigned to this project.',
            'data' => [],
        ]);
    }

    // Format the response to return only relevant user data
    $employeesData = $assignedEmployees->map(function ($assignment) {
        return $assignment->employee; // Assuming `employee()` returns the user model
    });

    return response()->json([
        'success' => true,
        'data' => $employeesData,
    ]);
       //dd($request);
        // $project = Project::with(['assignments', 'users'])->findOrFail($request->id);
        // return response()->json([
        //     'employees' => $project->users->map(function ($user) {
        //         return [
        //             'id' => $user->id,
        //             'name' => $user->name,
        //         ];
        //     }),
        // ]);


//         $projectAsn = ProjectAssign::with('employee')->where('project_id',$request->id)->get();
// dd($projectAsn);

//         if ($projectAsn->isEmpty()) {
//                         return response()->json(['error' => 'No project assignments found.'], 404);
//                     }
//         return response()->json([
//             'employees' => $projectAsn->employee->map(function ($employee) {
//                 return [
//                     'id' => $employee->id,
//                     'name' => $employee->name,
//                 ];
//             }),
//         ]);

    //    $projectAsn = ProjectAssign::with('employee')->where('project_id',$request->id)->get();
    //    if ($projectAsn->isEmpty()) {
    //             return response()->json(['error' => 'No project assignments found.'], 404);
    //         }
    //    //dd($projectAsn);
    //     return response()->json([
    //         'employees' => $projectAsn->employee->map(function ($employee) {
    //             return [
    //                 'id' => $employee->id,
    //                 'name' => $employee->name,
    //                 // 'asnId'=>$projectAsn->id,
    //             ];
    //         })
    //     ]);


    }

//     public function empList(Request $request)
// {
//     // Fetch ProjectAssign records for the specified project ID
//     $projectAssignments = ProjectAssign::with('employee')
//         ->where('project_id', $request->id)
//         ->get();
         
//         dd($projectAssignments);

//     if ($projectAssignments->isEmpty()) {
//         return response()->json(['error' => 'No project assignments found.'], 404);
//     }

//     // Prepare employees' data
//     $employees = $projectAssignments->flatMap(function ($assignment) {
//         return $assignment->employee->map(function ($employee) use ($assignment) {
//             return [
//                 'id' => $employee->id,
//                 'name' => $employee->name,
//                 'asnId' => $assignment->id,
//             ];
//         });
//     });

//     return response()->json(['employees' => $employees]);
// }


    
    public function create()
    {
       // $projects = Project::with('assignments.user')->get();
        $projects = Project::get();
        return view('admin.module.create', compact('projects'));
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'assignments' => 'required|array',
            'assignments.*' => 'exists:project_assign,id',
        ]);

 
        $module = ProjectModule::create([
            'project_id' => $request->project_id,
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        // Assign employees to the module
        foreach ($request->assignments as $assignmentId) {
            ProjectModuleDetail::create([
                'module_id' => $module->id,
                'assign_project_id' => $assignmentId,
            ]);
        }

        return redirect()->route('admin.module.index')->with('success', 'Module created successfully.');
    }


   
}
