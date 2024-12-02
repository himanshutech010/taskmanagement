@extends('layout.admin.default')
@section('title','Create Module')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Create a Module </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.modules.index') }}" class="btn btn-block btn-lg btn-gradient-success">Back</a>
                </li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Module Entry</h4>
                    <form class="forms-sample" method="post" action="{{ route('admin.modules.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="project">Select Project<span class="text-danger">*</span></label>
                                <select id="project" name="project_id" class="form-control form-control-sm" required onchange="loadProjectEmployees(this.value)">
                                    <option value="" disabled selected>Choose...</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="module_name">Module Name<span class="text-danger">*</span></label>
                                <input id="module_name" class="form-control" type="text" name="name" value="{{ old('name') }}" placeholder="Enter Module Name" required>
                                @error('name')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="employee">Assign Employee(s)<span class="text-danger">*</span></label>
                                <select id="employee" name="employees[]" class="form-control" multiple required>
                                    <!-- Employee options will be populated dynamically -->
                                </select>
                                @error('employees')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="start_date">Start Date<span class="text-danger">*</span></label>
                                <input id="start_date" name="start_date" class="form-control" type="date" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="end_date">End Date<span class="text-danger">*</span></label>
                                <input id="end_date" name="end_date" class="form-control" type="date" value="{{ old('end_date') }}" required>
                                @error('end_date')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                          
                        </div>

                        <button type="submit" class="btn btn-gradient-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function loadProjectEmployees(projectId) {
        // Clear previous data
        document.getElementById('employee').innerHTML = '';

        fetch(`/admin/project/${projectId}/employees`)
            .then(response => response.json())
            .then(data => {
                data.employees.forEach(employee => {
                    const option = new Option(employee.name, employee.id);
                    document.getElementById('employee').add(option);
                });
            });
    }
</script>
@endsection
