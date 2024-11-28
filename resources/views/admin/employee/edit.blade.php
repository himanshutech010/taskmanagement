@extends('layout.admin.default')
@section('title','Edit User')
@section('content')

<div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Edit a Employee </h3>
              <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                
                <li class="breadcrumb-item"><a href="{{ route('admin.employee.index') }}" class="btn btn-block btn-lg btn-gradient-success">Back</a>
              </li>
                
              </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                  <div class="card">
                      <div class="card-body">
                          <h4 class="card-title mb-4">Edit Employee Form</h4>
                          {{-- {{dd($user)}} --}}
                          <form class="forms-sample" method="post" action="{{ route('admin.employee.update', $user->id) }}" enctype="multipart/form-data">
                              @csrf
                              @method('PUT')
                              <div class="row mb-4">
                                  <!-- Full Name -->
                                  <div class="form-group col-md-6">
                                      <label for="name">Full Name<span class="text-danger">*</span></label>
                                      <input id="name" class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Enter Full Name" >
                                      @if($errors->has("name"))
                                      <span class="error-message">{{ $errors->first('name') }}</span>
                                      @endif
                                  </div>
          
                                  <!-- Email -->
                                  <div class="form-group col-md-6">
                                      <label for="email">Email<span class="text-danger">*</span></label>
                                      <input id="email" name="email" class="form-control" type="email" value="{{ old('email', $user->email) }}" placeholder="Enter Email" >
                                      @if($errors->has("email"))
                                      <span class="error-message">{{ $errors->first('email') }}</span>
                                      @endif
                                  </div>
                              </div>
          
                              <div class="row mb-4">
                                  <!-- Username -->
                                  <div class="form-group col-md-6">
                                      <label for="username">Username<span class="text-danger">*</span></label>
                                      <input id="username" class="form-control" type="text" name="user_name" value="{{ old('user_name', $user->user_name) }}" placeholder="Enter Username" >
                                      @if($errors->has("user_name"))
                                      <span class="error-message">{{ $errors->first('user_name') }}</span>
                                      @endif
                                  </div>
          
                                  <!-- Contact Number -->
                                  <div class="form-group col-md-6">
                                      <label for="phone">Contact Number</label>
                                      <input id="phone" name="phone" class="form-control" type="tel" value="{{ old('phone', $user->phone) }}" placeholder="+91">
                                      @if($errors->has("phone"))
                                      <span class="error-message">{{ $errors->first('phone') }}</span>
                                      @endif
                                  </div>
                              </div>
          
                              <div class="row mb-4">
                                  <!-- Date of Birth -->
                                  <div class="form-group col-md-6">
                                      <label for="dob">Date of Birth</label>
                                      <input id="dob" name="date_of_birth" class="form-control" type="date" value="{{ old('date_of_birth', $user->date_of_birth) }}">
                                      @if($errors->has("date_of_birth"))
                                      <span class="error-message">{{ $errors->first('date_of_birth') }}</span>
                                      @endif
                                  </div>
          
                                  <!-- Gender -->
                                  <div class="form-group col-md-6">
                                      <label for="gender">Gender<span class="text-danger">*</span></label>
                                      <select id="gender" name="gender" class="form-control form-control-sm">
                                          <option value="" disabled>Choose...</option>
                                          <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                          <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                          <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                      </select>
                                      @if($errors->has("gender"))
                                      <span class="error-message">{{ $errors->first('gender') }}</span>
                                      @endif
                                  </div>
                              </div>
                              {{-- password change --}}
<div class="row mb-4">

  <div class="form-group col-md-6">
    <label id="password" for="password" >Password</label>
    <input type="password" class="form-control" type="password" name="password" placeholder="Enter Your Password" >
        @if($errors->has("password"))
        <span class="error-message">{{ $errors->first('password') }}</span>
        @endif
  </div>
  
  <div class="form-group col-md-6">
    <label for="password_confirmation" >Confirm Password</label>
    <input type="password" name="password_confirmation"  id="password_confirmation" class="form-control" placeholder="Re-enter Your Password" >
    @if($errors->has("password_confirmation"))
                <span class="error-message"> {{ $errors->first('password_confirmation') }}</span>
            @endif
  </div>
            
                              <div class="row mb-4">
                                  <!-- Profile Image -->
                                  <div class="form-group col-md-6">
                                      <label>Profile Picture</label>
                                      <input type="file" name="image" class="file-upload-default">
                                      
                                      <div class="input-group ml-2">
                                          <input type="text" class="form-control file-upload-info " value="" disabled placeholder="Upload Image">
                                          <span class="input-group-append">
                                              <button class="file-upload-browse btn btn-gradient-success" type="button">Upload</button>
                                          </span>
                                      </div>
                                  </div>
    

                                  <!-- Role -->
                                  <div class="form-group col-md-6">
                                      <label for="role">Role<span class="text-danger">*</span></label>
                                      <select id="role" name="role" class="form-control form-control-sm" >
                                          <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
                                          <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                          <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                                      </select>
                                      @if($errors->has("role"))
                                      <span class="error-message">{{ $errors->first('role') }}</span>
                                      @endif
                                  </div>
                                              {{-- status --}}
          <div class="form-group col-md-4">
                        
            <label for="status">Status</label>
            <select class="form-control form-control-sm" id="status" name="status">
            <option value="1" {{$user->status == 1 ? 'selected' : ''}}>Active</option>
            <option value="0" {{$user->status == 0 ? 'selected' : ''}}>Inactive</option>
           </select>
          </div>
          <div class="row mb-4">
            <div class="form-group col-md-12">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4" placeholder="Enter description">{{ old('description', $user->description) }}</textarea>
                @if($errors->has("description"))
                <span class="error-message">{{ $errors->first('description') }}</span>
                @endif
            </div>
        </div>
        <div class="form-group col-md-4"><button type="submit" class="btn btn-gradient-success me-2 ml-3" style="width: 150px">Update</button></div>
        
      </div>
                              </div>
    
          
                             
                          </form>
                      </div>
                  </div>
              </div>
          </div>
          
      
          </div>

@endsection