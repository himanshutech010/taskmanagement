<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectModule;
use App\Models\ProjectModuleDetail;
use Illuminate\Http\Request;

class ModuleController extends Controller
{   

    public function index()
    {
        $modules = ProjectModule::with('project', 'details.assignProject.user')->get();
        return view('admin.module.index', compact('modules'));
    }

    
    public function create()
    {
        $projects = Project::with('assignments.user')->get();
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
