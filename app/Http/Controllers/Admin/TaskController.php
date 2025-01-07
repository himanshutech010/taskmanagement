<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskCheckList;
use App\Models\TaskCheckListComment;
use App\Models\TaskAssigne;
use App\Models\ProjectModule;
use App\Models\Project;
use App\Models\User;
use App\Models\ProjectAssign;


class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::where('isdelete', 0)->get();
        return view('admin.tasks.index', compact('tasks'));
    }


    public function create()
    {
        $modules = ProjectModule::all();
        $projects = Project::all();
        $users = User::where('isdeleted', 0)->where('status', 1)->get();
        return view('admin.tasks.create', compact('modules', 'projects', 'users'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'created_date' => 'required|date',
            'highPriority' => 'nullable|boolean',
            'Deadline' => 'nullable|date',
            'Module_id' => 'nullable|integer|exists:project_modules,id',
            'project_id' => 'nullable|integer|exists:projects,id',
            'userAssigneId' => 'required|array',
            'userAssigneId.*' => 'exists:users,id',
            'checklist1' => 'nullable|array',
            'checklist1.*.checklist_name' => 'required|string|max:255',
            'checklist1.*.is_active' => 'nullable|boolean',
            'commentValue' => 'nullable|array',
            'commentValue.*' => 'nullable|string|max:255',
        ]);

        // Adjust `highPriority` and other checkbox-related values
        $validated['highPriority'] = $request->has('highPriority') ? 0 : 1;

        // Automatically assign the user who created the task
        $validated['created_by'] = auth()->user()->id;

        // Create the task
        $task = Task::create([
            'name' => $validated['name'],
            'created_date' => $validated['created_date'],
            'highPriority' => $validated['highPriority'],
            'Deadline' => $validated['Deadline'] ?? null,
            'Module_id' => $validated['Module_id'] ?? null,
            'project_id' => $validated['project_id'] ?? null,
            'created_by' => $validated['created_by'],
        ]);

        // Create associated task checklists and comments
        if (!empty($validated['checklist1'])) {
            foreach ($validated['checklist1'] as $checklist) {
                $checkList = TaskCheckList::create([
                    'taskId' => $task->id,
                    'taskValue' => $checklist['checklist_name'],
                    'created_by' => $validated['created_by'],
                    'isactive' => isset($checklist['is_active']) && $checklist['is_active'] ? 0 : 1, // If checked, value is 0; otherwise, 1
                    'isdelete' => 0,
                ]);

                // Add comment for the checklist if provided
                if (!empty($validated['commentValue'][$checklist['checklist_name']])) {
                    TaskCheckListComment::create([
                        'taskCheckListId' => $checkList->id,
                        'commentValue' => $validated['commentValue'][$checklist['checklist_name']],
                        'created_by' => $validated['created_by'],
                        'isactive' => 1,
                        'isdelete' => 0,
                    ]);
                }
            }
        }

        // Assign the task to users
        foreach ($validated['userAssigneId'] as $userId) {
            TaskAssigne::create([
                'taskId' => $task->id,
                'userAssigneId' => $userId,
                'created_by' => $validated['created_by'],
                'isactive' => 1,
                'isdelete' => 0,
            ]);
        }

        // Redirect back with a success message
        return redirect()->route('admin.task.index')->with('success', 'Task created successfully!');
    }


    public function loadModules(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id', // Validate project_id
        ]);

        $modules = ProjectModule::where('project_id', $request->project_id)->get();

        return response()->json([
            'modules' => $modules,
        ]);
    }



    public function loadEmployees(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id', // Validate project_id
            'module_id' => 'nullable|exists:project_modules,id', // Validate module_id if provided    
        ]);

        $employees = [];

        if ($request->module_id) {
            $module = ProjectModule::with(['details.assignProject.employee'])->findOrFail($request->module_id);

            $employees = $module->details->map(function ($detail) {
                return [
                    'id' => $detail->assignProject->employee->id,
                    'name' => $detail->assignProject->employee->name,
                ];
            });
        }

        return response()->json([
            'employees' => $employees,
        ]);
    }


    public function show($id)
    {
        // Fetch the task by id
        $task = Task::find($id);

        if (!$task || $task->isdelete) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task);
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $projects = Project::all();
        $modules = ProjectModule::where('project_id', $task->project_id)->get();
        $taskCheckList = TaskCheckList::where('taskId', $id)->where('isdelete', 0)->get();
        $users = User::get();
        $comment = TaskCheckListComment::all();
        return view('admin.tasks.edit', compact('task', 'projects', 'modules', 'taskCheckList', 'comment', 'users'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            // Validation rules
            'name' => 'required|string|max:255',
            'created_date' => 'required|date',
            'highPriority' => 'boolean',
            'Deadline' => 'nullable|date',
            'Module_id' => 'nullable|integer|exists:project_modules,id',
            'project_id' => 'nullable|integer|exists:projects,id',
            'userAssigneId' => 'required|array',
            'userAssigneId.*' => 'exists:users,id',
            'taskValue' => 'nullable|array',
            'taskValue.*' => 'string|max:255',
            'commentValue' => 'nullable|array',
            'commentValue.*' => 'nullable|string|max:255',
            'isactive' => 'array',
            'isactive.*' => 'boolean',
            'taskCheckListIdd' => 'nullable|array',
            'commentValueId' => 'nullable|array',
            // 'isdelete'=>'required',

        ]);

        // dd( $request->isactive);
        $validated['modified_by'] = auth()->user()->id;

        $task = Task::findOrFail($id);

        $task->update([
            'name' => $validated['name'],
            'created_date' => $validated['created_date'],
            'highPriority' => $validated['highPriority'] ?? 0,
            'Deadline' => $validated['Deadline'] ?? null,
            'Module_id' => $validated['Module_id'] ?? null,
            'project_id' => $validated['project_id'] ?? null,
            'modified_by' => $validated['modified_by'],
        ]);




        // Handle task values and comments
        if (!empty($validated['taskValue'])) {
            foreach ($validated['taskValue'] as $index => $taskValue) {
                //  dd($index);
                $checkListId = $validated['taskCheckListIdd'][$index] ?? null;
                // dd($checkListId);
                if ($checkListId) {
                    // Update the existing checklist if it belongs to the current task
                    $checkList = TaskCheckList::where('id', $checkListId)
                        ->where('taskId', $task->id)
                        ->first();
                    // dd( $checkList);

                    if ($checkList) {
                        // Update the existing checklist values
                        $checkList->taskValue = $taskValue;
                        $checkList->modified_by = $validated['modified_by'];
                        $checkList->isactive = $validated['isactive'][$index] ?? 1;
                        // $checkList->isdelete = 0;
                        error_log('Some message here.');
                        $checkList->save();
                    } else {
                        // If no matching checklist is found, skip this iteration
                        continue;
                    }
                } else {
                    // Create a new checklist if no ID is provided
                    $checkList = new TaskCheckList();
                    $checkList->taskId = $task->id;
                    $checkList->taskValue = $taskValue;
                    $checkList->isactive = $validated['isactive'][$index] ?? 1;
                    $checkList->isdelete = 0;
                    $checkList->created_by = $validated['modified_by'];
                    error_log('Some message here.2');
                    $checkList->save();
                }

                // Handle comments associated with this checklist item
                if (!empty($validated['commentValue'][$index])) {
                    $commentId = $validated['commentValueId'][$index] ?? null;

                    if ($commentId) {
                        // Update the existing comment if it exists
                        $comment = TaskCheckListComment::where('id', $commentId)
                            ->where('taskCheckListId', $checkList->id)
                            ->first();

                        if ($comment) {
                            // Update existing comment values
                            $comment->commentValue = $validated['commentValue'][$index];
                            $comment->modified_by = $validated['modified_by'];
                            $comment->isactive = 1;
                            // $comment->isdelete = 0;
                            $comment->save();
                        } else {
                            // If no matching comment is found, skip this iteration
                            continue;
                        }
                    } else {
                        // Create a new comment if no comment ID is provided
                        $comment = new TaskCheckListComment();
                        $comment->taskCheckListId = $checkList->id;
                        $comment->created_by = $validated['modified_by'];
                        $comment->commentValue = $validated['commentValue'][$index];
                        $comment->isactive = 1;
                        $comment->isdelete = 0;
                        $comment->save();
                    }
                }
            }
        }

        // Update task assignees
        $task->assignees()->detach();
        foreach ($validated['userAssigneId'] as $userId) {
            $task->assignees()->attach($userId, [
                'created_by' => $validated['modified_by'],
                'isactive' => 1,
                'isdelete' => 0,
            ]);
        }

        return redirect()->route('admin.task.index')->with('success', 'Task updated successfully!');
    }

    public function destroy_cm($idc, $idm)
    {

        $taskc = TaskCheckList::find($idc);

        if (!$taskc || $taskc->isdelete) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Soft delete the task by updating the isdelete flag
        $taskc->update(['isdelete' => 1]);
        if ($idm != '00') {
            $taskm = TaskCheckListComment::findOrFail($idm);
            $taskm->isdelete = 1;
            $taskm->save();
        }
        // return response()->json(['message' => 'Task deleted successfully']);
        // return view('admin.tasks.edit')->with('success', ' TaskcheckList deleted successfully');
        return redirect()->back()->with('success', 'TaskCheckList deleted successfully');
    }


    public function destroy($id)
    {
        // Fetch the task by id
        $task = Task::find($id);

        if (!$task || $task->isdelete) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        // Soft delete the task by updating the isdelete flag
        $task->update(['isdelete' => 1]);
        // return response()->json(['message' => 'Task deleted successfully']);
        return redirect()->route('admin.task.index')->with('success', ' Task deleted successfully');
    }
}
