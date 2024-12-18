@extends('layout.admin.default')
@section('title','Create Employee')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Create a Department </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.department.index') }}" class="btn btn-block btn-lg btn-gradient-success">Back</a>
                </li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Department Form</h4>
                    <form class="forms-sample" method="post" action="{{ route('admin.department.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                        
                            <div class="form-group col-md-6">
                                <label for="name">Department Name<span class="text-danger">*</span></label>
                                <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" placeholder="Enter Full Name"  >
                                @if($errors->has("name"))
                                <span class="error-message">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                           
                        </div>


                        <button type="submit" class="btn btn-gradient-success me-2">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
