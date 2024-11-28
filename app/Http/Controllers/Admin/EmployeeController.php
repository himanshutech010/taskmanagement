<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
 
    public function index()
    {
      

        // List all employees
        $records=User::orderBy('id',"desc")->get();
       return view('admin.employee.index',compact('records'));
     
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
        // 'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
      'user_name' => ['required', 'string', 'max:255', 'unique:users,user_name'], // Matches the DB column name
        'password' => ['required', 'confirmed'], // Password must match password_confirmation
        'phone' => ['nullable', 'string', 'max:10', 'min:10'],
        'date_of_birth' => ['nullable', 'date'], // Matches the DB column name
        'gender' => ['required', 'in:male,female,other'],
        'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        'role' => ['required', 'in:staff,admin,manager'],
        'description' => ['nullable', 'string', 'max:500'],
    ]);

   
    if($request->hasFile('image')) {
        $file = $request->file('image');
        $image_name = time().'.'.$request->file('image')->getClientOriginalExtension();
        
            if (!file_exists(public_path('admin/images/profile/'))) {
                mkdir(public_path('admin/images/profile/'), 0777, true);
            }

        $file->move(public_path('admin/images/profile/'),$image_name);
        $validated['image'] = $image_name;
        
    }

    // Encrypt the password
    $validated['password'] = Hash::make($validated['password']);

    // Set default status to active
    $validated['status'] = 1;

    // Create the employee

    $user = User::create($validated);


    return redirect()->route('admin.employee.index')->with('success', 'Employee created successfully.');
}



    public function edit($id)
    { 

        $user = User::findOrfail($id);
       // dd($user);
        return view('admin.employee.edit',compact('user'));
    }

    public function update(Request $request, $id)
    {
        
        $user = User::findOrfail($id);
      
        $validated = $request->validate([
           'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            // 'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',ValidationRule::unique('users')->ignore($user->id)],
          'user_name' => ['required', 'string', 'max:255', ValidationRule::unique('users')->ignore($user->id)], // Matches the DB column name
          'password' => ['nullable', 'confirmed'],// Password must match password_confirmation
            'phone' => ['nullable', 'string', 'max:10', 'min:10'],
            'date_of_birth' => ['nullable', 'date'], // Matches the DB column name
            'gender' => ['required', 'in:male,female,other'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'role' => ['required', 'in:staff,admin,manager'],
            'description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'string', 'in:1,0'], 
        ]);
        
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $image_name = time().'.'.$request->file('image')->getClientOriginalExtension();
            
                if (!file_exists(public_path('admin/images/profile/'))) {
                    mkdir(public_path('admin/images/profile/'), 0777, true);
                }
    
            $file->move(public_path('admin/images/profile/'),$image_name);
            $validated['image'] = $image_name;
            
        }
    
       // dd($request->status);
        $validated['status']=$request->status=="1" ? 1:0;
       // dd( $validated['status']);
        if($request->filled('password')){
            $validated['password'] = Hash::make($request->password);
        }
        else{
            unset($validated['password']);
        }

        $user->fill($validated);
        
        // $user->password = Hash::make($validated['password']);
        $user->save();
        return redirect()->route('admin.employee.index')->with('success', 'User Updated successfully');
    }


    public function destroy($id)
    {
        $user = User::findOrfail($id);
//dd($user);
        $user->delete();
        return redirect()->route('admin.employee.index')->with('success', 'User deleted successfully');
    }


}

