<?php



namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{


    public function index()
    {
        $departments = Department::with('user')->get();
        return view('admin.department.index', compact('departments'));
    }


    public function create()
    {
        return view('admin.department.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'user_id' => 'nullable|exists:users,id',
        ]);

        Department::create($request->all());

        return redirect()->route('admin.department.index')->with('success', 'Department created successfully.');
    }


    public function show($id)
    {

        $department = Department::with(['users' => function ($query) {
            $query->where('isdeleted', 0);
        }])->findOrFail($id);


        $assignedUserIds = $department->users->pluck('id');


        $unassignedUsers = User::where('isdeleted', 0)->where('status', 1)
            ->whereNotIn('id', $assignedUserIds)
            ->get();

        return view('admin.department.show', compact('department', 'unassignedUsers'));
    }


    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('admin.department.edit', compact('department'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
        ]);
        $department = Department::findOrFail($id);
        $department->update([
            'name' => $request->input('name'),
        ]);
        return redirect()->route('admin.department.index')->with('success', 'Department updated successfully.');
    }



    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->route('admin.department.index')->with('success', 'Department deleted successfully.');
    }


    public function assignUser(Request $request, $id)
    {
        $department = Department::findOrFail($id);


        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);


        $user = User::findOrFail($request->user_id);
        $department->users()->attach($user);

        return redirect()->route('admin.department.show', $id)->with('success', 'User assigned to the department successfully.');
    }


    public function detachUser($departmentId, $userId)
    {
        $department = Department::findOrFail($departmentId);


        if ($department->users->contains($userId)) {
            $department->users()->detach($userId);
            return redirect()->back()->with('success', 'User detached from department successfully.');
        }

        return redirect()->back()->with('error', 'User not found in this department.');
    }
}
