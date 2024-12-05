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

        $modules = ProjectModule::with('project')->get();
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
}
