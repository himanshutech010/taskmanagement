<?php

namespace App\Http\Controllers\Admin\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

// use Hash;
use Illuminate\Support\Facades\File;

class LoginController extends Controller
{
    public function showLoginForm()
    {   
        if (Auth::check()) {
            return redirect()->route('admin.dashboard.index');
        }
        return view('admin.auth.login'); 
    }


    public function adminLogin(Request $request)
{
    // Validate the input
    $request->validate([
        'email' => 'required|email|exists:users,email', // Check if the email exists in the database
        'password' => 'required|min:6',
    ]);

    // Capture credentials
    $credentials = $request->only('email', 'password');

    // Check if the email exists
    $user = User::where('email', $credentials['email'])->first();

    if (!$user) {
        // Email does not exist
        return redirect()->back()->withErrors(['email' => 'The provided email does not match our records.']);
    }

    // Verify the password
    if (!Hash::check($credentials['password'], $user->password)) {
        // Password is incorrect
        return redirect()->back()->withErrors(['password' => 'The provided password is incorrect.']);
    }

    // Attempt login with the provided credentials
    if (Auth::attempt($credentials)) {
        // Authentication passed

$user = Auth::user();
$user->update(['is_online' => 1]);

        return redirect()->route('admin.dashboard.index')->with('success', 'Login successfully');
    }

    // Default fallback (should not reach here due to above checks)
    return redirect()->back()->withErrors(['email' => 'Authentication failed.']);
}



    public function logout()
    {
 
        $user = Auth::user();
        $user->update(['is_online' => 0]);
    
        Auth::logout();
        return redirect()->route('admin.login');
    }
    public function resetpassword()
    {
        return view('admin.auth.resetpassword'); 
    }

    public function profile(){
        $user = User::findOrfail(1);  
        return view('admin.info.profile-info', compact('user'));
    }


    // public function adminLogout()
    // {
    //     Auth::guard('admin')->logout();
    //     return redirect()->route('admin.showLoginForm');
    // }

    public function changePassword()
    {
        $user = User::findOrfail(1);  
      return view('admin.info.changepassword', compact('user'));
    }

    // public function passwordUpdate(ChangePasswordRequest $request, $id)
    // {
    //     $validated = $request->validated();
    //     $admin = Admin::findOrfail($id);
        
        
    //     if($request->password){
    //         $validated['password'] = Hash::make($request->password);
    //     }

    //     $admin->fill($validated);
        
    //     // $user->password = Hash::make($validated['password']);
    //     $admin->save();
    //     return redirect()->route('admin.dashboard.index')->with('success', 'Password Updated successfully');
    // }

   

    public function profileUpdate(Request $request , $id)
    {

    // $user = Auth::guard('users')->user();
    $user = User::findOrfail($id);


    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
        'user_name' => ['required', 'string', 'max:255', Rule::unique('users', 'user_name')->ignore($user->id)],
        'phone' => ['nullable', 'string', 'max:15'],
        'date_of_birth' => ['nullable', 'date'],
        'gender' => ['required', 'in:male,female,other'],
        'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        'description' => ['nullable', 'string', 'max:500'],
    ]);

    // Handle image upload
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $image_name = time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('admin/images/profile/');

        // Ensure the directory exists
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true);
        }

        // Delete old image if it exists
        $oldImagePath = $destinationPath . $user->image;
        if ($user->image && File::exists($oldImagePath)) {
            File::delete($oldImagePath);
        }

        // Move the new image to the directory
        $file->move($destinationPath, $image_name);
        $validated['image'] = $image_name;
    }

    // Update the user profile
    $user->update($validated);

    // Redirect with success message
    return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
}

public function userPassword($id)
{
    $user = User::findOrfail($id);  
  return view('admin.info.changepassword', compact('user'));
}
public function passwordUpdate(ChangePasswordRequest $request, $id)
    {
        // dd($id);
        $validated = $request->validated();
        $user = User::findOrfail($id);
        
        
        if($request->password){
            $validated['password'] = Hash::make($request->password);
        }

        $user->fill($validated);
        
        // $user->password = Hash::make($validated['password']);
        $user->save();
        return redirect()->route('admin.dashboard.index')->with('success', 'Password Updated successfully');
    }

}
