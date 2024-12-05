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
        $projects = Project::where('isdeleted', 0)->with(['users', 'client'])->get();
        $assinProjects = ProjectAssign::with('department')->get();

        return view('admin.project.index', compact('projects', 'assinProjects'));
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



    public function showByList(Request $request)
    {
        $departmentId = $request->id;

        $department = Department::with(['users' => function ($query) {
            $query->where('isdeleted', 0)->where('status', 1);
        }])->findOrFail($departmentId);

        return response()->json([
            'employees' => $department->users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                ];
            }),
        ]);
    }


    public function edit($id)
    {
        // Retrieve the project with its related data
        $project = Project::with(['assignments', 'users'])->findOrFail($id);
        // dd($project);
        // $project= $project->where('isdeleted', 0);

        $clients = Client::all();
        $departments = Department::all();
        $assinProjects = ProjectAssign::with('department')->get();


        // Fetch the employees and moderator details from the assignments

        // $assignedEmployees = $project->assignments->pluck('user_id')->toArray();
        $assignedEmployees = $project->assignments->pluck('user_id')->toArray();

        // $assignedEmployees = $project->assignments->toArray();
        //    dd( $assignedEmployees);
        // dd($assignedEmployees);
        $moderator = $assinProjects->where('project_id', $project->id)->where('is_moderator', true)->first()?->employee;
        // $moderator = $project->assignments->where('is_moderator', true)->first()?->user; 

        return view('admin.project.edit', compact('project', 'clients', 'departments', 'assinProjects', 'assignedEmployees', 'moderator'));
    }

    public function update(Request $request, $id)
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

        $project = Project::findOrFail($id);

        // Update project details
        $project->update([
            'name' => $validated['name'],
            'client_id' => $validated['client_id'],
            'status' => $validated['status'],
            'url' => $validated['url'],
            'description' => $validated['description'],
            'date' => $validated['date'],
        ]);

        // Remove existing assignments and create new ones
        ProjectAssign::where('project_id', $id)->delete();

        foreach ($validated['employees'] as $employeeId) {
            ProjectAssign::create([
                'project_id' => $project->id,
                'dept_id' => $validated['department_id'],
                'user_id' => $employeeId,
                'is_moderator' => $employeeId == $validated['moderator'],
            ]);
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully!');
    }

    public function destroy($id)
    {
        $proj = Project::findOrFail($id);
        $proj->isdeleted = 1;
        $proj->save();

        return redirect()->route('admin.projects.index')->with('success', ' Project deleted successfully');
    }
}
