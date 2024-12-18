<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EmployeeController extends Controller
{

    public function index()
    {
        // List all employees
        $records = User::where('isdeleted', 0)->orderBy('id', "desc")->get();
        return view('admin.employee.index', compact('records'));
    }

    public function create()
    {
        $user = new User();
        $roles = ['Super Admin', 'Manager', 'Staff'];
        return view('admin.employee.create', compact('user', 'roles'));
    }


    public function store(Request $request)
    {
        // Validate input data
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'user_name' => ['required', 'string', 'max:255', 'unique:users,user_name'],
            'password' => ['required', 'confirmed'],
            'phone' => ['nullable', 'numeric',  'digits_between:10,10'],
            'role' => ['required', 'in:Super Admin,Manager,Staff'],
            'gender' => ['required', 'in:Male,Female,Other'],
            'date_of_birth' => ['nullable', 'date', 'before_or_equal:' . Carbon::today()],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);


        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image_name = time() . '.' . $request->file('image')->getClientOriginalExtension();

            if (!file_exists(public_path('admin/images/profile/'))) {
                mkdir(public_path('admin/images/profile/'), 0777, true);
            }

            $file->move(public_path('admin/images/profile/'), $image_name);
            $validated['image'] = $image_name;
        }

        // Encrypt the password
        $validated['password'] = Hash::make($validated['password']);


        $validated['status'] = 1;

        // Create the employee

        $user = User::create($validated);
        $user->save();

        return redirect()->route('admin.employee.index')->with('success', 'Employee created successfully.');
    }



    public function edit($id)
    {

        $user = User::findOrfail($id);
        // dd($user);
        return view('admin.employee.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {

        $user = User::findOrfail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required',  'email:rfc,dns', 'max:255', ValidationRule::unique('users')->ignore($user->id)],
            'user_name' => ['required', 'string', 'max:255', ValidationRule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:10', 'min:10'],
            'role' => ['required', 'in:Super Admin,Manager,Staff'],
            'gender' => ['required', 'in:Male,Female,Other'],
            'date_of_birth' => ['nullable', 'date', 'before_or_equal:' . Carbon::today()],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'string', 'in:1,0'],
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $image_name = time() . '.' . $request->file('image')->getClientOriginalExtension();

            if (!file_exists(public_path('admin/images/profile/'))) {
                mkdir(public_path('admin/images/profile/'), 0777, true);
            }

            $file->move(public_path('admin/images/profile/'), $image_name);
            $validated['image'] = $image_name;
        }


        $validated['status'] = $request->status == "1" ? 1 : 0;
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->fill($validated);

        $user->save();
        return redirect()->route('admin.employee.index')->with('success', 'User Updated successfully');
    }



    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->isdeleted = 1;
        $user->save();

        return redirect()->route('admin.employee.index')->with('success', 'User deleted successfully');
    }

    public function show($id)
    {
        $employee = User::with('departments')->findOrFail($id);
        return view('admin.employee.details', compact('employee'));
    }

    public function toggleStatus(Request $request)
{
    $employee = User::findOrFail($request->id);
    $employee->status = !$employee->status;
    $employee->save();

    return response()->json([
        'success' => true,
        'newStatus' => $employee->status,
        'statusText' => $employee->status == 1 ? 'Active' : 'Inactive',
        'statusClass' => $employee->status == 1 ? 'badge-success' : 'badge-danger'
    ]);
}
}
