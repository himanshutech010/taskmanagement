@extends('layout.admin.default')
@section('title','Users')
@section('content')

<div class="content-wrapper">
           
            <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Profile-Info Manage</h4>
                    <p class="card-description"></p>
                    <form class="forms-sample"  method="post" action="{{ route('admin.profileUpdate',['id'=> $user->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')  
                    <div class="row ">
                    <div class="form-group col-md-6">
                      <label for="name">Full Name<span class="text-danger">*</span></label>
                      <input id="name" class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Enter Full Name" >
                      @if($errors->has("name"))
                      <span class="error-message">{{ $errors->first('name') }}</span>
                      @endif
                    </div>
                    <div class="form-group col-md-6">
                      <label for="username">Username<span class="text-danger">*</span></label>
                      <input id="username" class="form-control" type="text" name="user_name" value="{{ old('user_name', $user->user_name) }}" placeholder="Enter Username" >
                      @if($errors->has("user_name"))
                      <span class="error-message">{{ $errors->first('user_name') }}</span>
                      @endif
                  </div>
                </div>
                    <div class="row ">
                      <div class="form-group  col-md-6">
                        <label for="email" :value="__('Email')">Email address</label>
                        <input id="email" name="email" value="{{ old('email',$user->email) }}" class="form-control" type="email"  placeholder="Email">
                        @if($errors->has("email"))
                            <span class="error-message">{{ $errors->first('email') }}</span>
                            @endif
                      </div>
                                                        <div class="form-group col-md-6">
                                                          <label for="phone">Contact Number</label>
                                                          <input id="phone" name="phone" class="form-control" type="tel" value="{{ old('phone', $user->phone) }}" placeholder="+91">
                                                          @if($errors->has("phone"))
                                                          <span class="error-message">{{ $errors->first('phone') }}</span>
                                                          @endif
                                                      </div>
                                                    </div>
                                                      <div class="row ">
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
                      <div class="row ">

                        <div class="form-group col-md-6 ">
                        <label>Profile Picture</label>
                        
                        <input type="file" name="image" class="file-upload-default">
                        <div class="input-group  ml-2 ">
                          <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                       
                            
                                
                            
                          <span class="input-group-append">
                            <button class="file-upload-browse btn btn-gradient-success" type="button">Upload</button>
                          </span>
                        </div>
                        </div>


                      </div>
                      
                      <button type="submit" class="btn btn-gradient-success me-2">Update</button>
                     
                
                      <a href="{{ route('admin.dashboard.index') }}" class="btn btn-outline-success me-2">Cancel</a> 
                
              
                      
                    </form>
                  </div>
                </div>
              </div>
              
            </div>
</div>
@endsection