<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectAssign;
use App\Models\ProjectModule;
use App\Models\ProjectModuleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{

    public function index()
    {

        $modules = ProjectModule::with(['project','details.assignProject.employee'])->get();
        // $assignedEmployees = ProjectAssign::with('employee')
        // ->whereHas('project', function ($query) use ($module) {
        //     $query->where('id', $module->project_id);
        // })
        // ->get();
        return view('admin.module.index', compact('modules'));
    }

    public function create()
    {
        // $projects = Project::with('assignments.user')->get();
        $projects = Project::get();
        return view('admin.module.create', compact('projects'));
    }

    public function empList(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'id' => 'required|exists:projects,id', // Ensure the project ID exists
        ]);

        // Fetch the employees assigned to the selected project
        $employees = ProjectAssign::where('project_id', $request->id)
            ->with('employee') // Fetch the related employee details
            ->get()
            ->map(function ($assignment) {
                return [
                
                    'id' => $assignment->employee->id,
                    'name' => $assignment->employee->name,
                ];
            
            });

        // Return the employees as a JSON response
        return response()->json(['employees' => $employees]);
        }





    public function store(Request $request)
    { // Step 1: Validate the incoming data
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'employees' => 'required|array',
            'employees.*' => 'exists:users,id', // Ensure all employee IDs are valid
        ]);

        try {
            // Step 2: Start a database transaction
            DB::beginTransaction();

            // Step 3: Create the module in `ProjectModule`
            $module = ProjectModule::create([
                'project_id' => $validated['project_id'],
                'name' => $validated['name'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
            ]);

            // Step 4: Loop through employees and create records in `ProjectModuleDetail`
            foreach ($validated['employees'] as $employeeId) {
                // Find the related ProjectAssign record
                $assign = ProjectAssign::where('project_id', $validated['project_id'])
                    ->where('user_id', $employeeId)
                    ->first();

                if ($assign) {
                    ProjectModuleDetail::create([
                        'module_id' => $module->id,
                        'assign_project_id' => $assign->id,
                    ]);
                }
            }

            // Step 5: Commit the transaction
            DB::commit();

            return redirect()->route('admin.modules.index')->with('success', 'Module created successfully!');
        } catch (\Exception $e) {
            // Step 6: Rollback the transaction on failure
            DB::rollBack();

            return back()->withErrors(['error' => 'Failed to create module: ' . $e->getMessage()]);
        }
    }


    public function edit($id)
{
    // Fetch the module to be edited along with project and assigned employees// 
    $module = ProjectModule::with(['details.assignProject.employee', 'project'])->findOrFail($id);
    // dd($module);

    // Fetch all projects for the dropdown
    $projects = Project::all();

    // Fetch employees specifically assigned to the current module
    $assignedEmployees = ProjectAssign::with('employee')
        ->whereHas('project', function ($query) use ($module) {
            $query->where('id', $module->project_id);
        })
        ->get();

    // Fetch employees already selected in the module
    $moduleAssignedEmployees = $module->details->pluck('assign_project_id')->toArray();

    return view('admin.module.edit', [
        'module' => $module,
        'projects' => $projects,
        'assignedEmployees' => $assignedEmployees,
        'moduleAssignedEmployees' => $moduleAssignedEmployees,
    ]);
}


public function update(Request $request, $id)
{
    // Step 1: Validate the incoming data
    $validated = $request->validate([
        'project_id' => 'required|exists:projects,id',
        'name' => 'required|string|max:255',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'employees' => 'required|array',
        'employees.*' => 'exists:users,id', 
    ]);

    try {
        // Step 2: Start a database transaction
        DB::beginTransaction();

        // Step 3: Find the module to update
        $module = ProjectModule::findOrFail($id);

        // Update the module details
        $module->update([
            'project_id' => $validated['project_id'],
            'name' => $validated['name'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        // Step 4: Find all related `ProjectAssign` records for the given employees
        $assignments = ProjectAssign::where('project_id', $validated['project_id'])
            ->whereIn('user_id', $validated['employees'])
            ->get();

        // Step 5: Update `ProjectModuleDetail`
        // Remove existing employee assignments for the module
        ProjectModuleDetail::where('module_id', $module->id)->delete();

        // Prepare new employee assignments
        $moduleDetails = [];
        foreach ($assignments as $assign) {
            $moduleDetails[] = [
                'module_id' => $module->id,
                'assign_project_id' => $assign->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Bulk insert new assignments
        ProjectModuleDetail::insert($moduleDetails);

        // Step 6: Commit the transaction
        DB::commit();

        return redirect()->route('admin.modules.index')->with('success', 'Module updated successfully!');
    } catch (\Throwable $e) {
        // Step 7: Rollback the transaction on failure
        DB::rollBack();

       

        return back()->withErrors(['error' => 'Failed to update module: ' . $e->getMessage()]);
    }
}





}
