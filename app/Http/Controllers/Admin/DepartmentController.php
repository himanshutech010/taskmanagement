<?php



namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the departments with users.
     */
    public function index()
    {
        $departments = Department::with('user')->get(); // Eager load users
        return view('admin.department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new department.
     */
    public function create()
    {
        return view('admin.department.create');
    }

    /**
     * Store a newly created department in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
        ]);

        Department::create($request->all());

        return redirect()->route('admin.department.index')->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified department along with its users.
     */



    public function show($id)
    {

        $department = Department::with(['users' => function ($query) {
            $query->where('isdeleted', 0)->where('status', 1);
        }])->findOrFail($id);


        $assignedUserIds = $department->users->pluck('id');


        $unassignedUsers = User::where('isdeleted', 0)->where('status', 1)
            ->whereNotIn('id', $assignedUserIds)
            ->get();

        return view('admin.department.show', compact('department', 'unassignedUsers'));
    }

    /**
     * Show the form for editing the specified department.
     */

    public function edit($id)
    {
        // dd($id);
        $department = Department::findOrFail($id);
        return view('admin.department.edit', compact('department'));
    }


    /**
     * Update the specified department in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
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


    /**
     * Assign users to a department.
     */
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
