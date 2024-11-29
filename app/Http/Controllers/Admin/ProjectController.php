<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Department;
use App\Models\Project;
use App\Models\ProjectAssign;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('user')->get();
        return view('admin.project.index', compact('projects'));
    }


    // Show form to create a new project
    public function create()
    {
        $clients = Client::all();
        $departments = Department::all();
        return view('admin.project.create', compact('clients', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'department_id' => 'required|exists:departments,id',
            'employees' => 'required|array',
            'moderator' => 'required|exists:users,id',
            'status' => 'required|in:Dev,Live',
            'date' => 'nullable|date',
            'url' => 'nullable|url',
            'description' => 'nullable|string',
        ]);

        $project = Project::create([
            'name' => $validated['name'],
            'client_id' => $validated['client_id'],
            'status' => $validated['status'],
            'url' => $validated['url'],
            'description' => $validated['description'],
            'date' => $validated['date'],
        ]);

        foreach ($validated['employees'] as $employeeId) {
            ProjectAssign::create([
                'project_id' => $project->id,
                'dept_id' => $validated['department_id'],
                'user_id' => $employeeId,
                'is_moderator' => $employeeId == $validated['moderator'],
            ]);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully!');
    }
}
