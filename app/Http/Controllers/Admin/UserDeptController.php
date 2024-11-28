<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class UserDeptController extends Controller
// {
//     //
// }
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;

class UserDeptController extends Controller
{
    // Show the relationship data
    public function show($id)
    {
        $department = Department::findOrFail($id);
        $users = User::all();  
        return view('departments.show', compact('department', 'users'));
    }

    // Assign departments to a user
    // public function assign(Request $request, $userId)
    // {
    //     $user = User::findOrFail($userId);
    //     $user->departments()->sync($request->department_ids); // Sync the relationship
    //     return redirect()->back()->with('success', 'Departments assigned successfully.');
  
    // }


    

    // // Detach a department from a user
    // public function detach($userId, $deptId)
    // {
    //     $user = User::findOrFail($userId);
    //     $user->departments()->detach($deptId);
    //     return redirect()->back()->with('success', 'Department detached successfully.');
    // }

    public function assignUser(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $department = Department::findOrFail($id);
        $department->users()->attach($request->user_id);

        return redirect()->route('departments.show', $id)->with('success', 'User assigned successfully!');
    }

    // Optionally, you can also remove the user from the department
    public function removeUser(Request $request, $deptId, $userId)
    {
        $department = Department::findOrFail($deptId);
        $department->users()->detach($userId);

        return redirect()->route('departments.show', $deptId)->with('success', 'User removed successfully!');
    }
}




/////////
// use App\Http\Controllers\UserDeptController;

// Route::prefix('user-department')->group(function () {
//     Route::get('/', [UserDeptController::class, 'index'])->name('user-dept.index');
//     Route::post('/assign/{userId}', [UserDeptController::class, 'assign'])->name('user-dept.assign');
//     Route::delete('/detach/{userId}/{deptId}', [UserDeptController::class, 'detach'])->name('user-dept.detach');
// });
