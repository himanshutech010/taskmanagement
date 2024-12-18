@extends('layout.admin.default')
@section('title', 'Edit Department')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Edit Department </h3>
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
                    <h4 class="card-title">Edit Department Form</h4>
                    <form class="forms-sample" method="POST" action="{{ route('admin.department.update', $department->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Use PUT method for updating -->

                        <div class="row mb-4">
                            <!-- Department Name -->
                            <div class="form-group col-md-6">
                                <label for="name">Department Name <span class="text-danger">*</span></label>
                                <input id="name" class="form-control" type="text" name="name" value="{{ old('name', $department->name) }}" placeholder="Enter Department Name">
                                @if($errors->has("name"))
                                <span class="error-message text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="btn btn-gradient-success mr-2">Save Changes</button>
                        <a href="{{ route('admin.department.index') }}" class="btn btn-outline-success me-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection




