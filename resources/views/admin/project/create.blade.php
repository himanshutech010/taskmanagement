@extends('layout.admin.default')
@section('title','Create Project')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Create a Project </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-block btn-lg btn-gradient-success">Back</a>
                </li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Project Entry</h4>
                    <form class="forms-sample" method="post" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Project Name<span class="text-danger">*</span></label>
                                <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" placeholder="Enter Project Name" required>
                                @error('name')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="client">Client<span class="text-danger">*</span></label>
                                <select id="client" name="client_id" class="form-control" required>
                                    <option value="" disabled selected>Choose...</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="department">Department<span class="text-danger">*</span></label>
                                <select id="department" name="department_id" class="form-control" required onchange="loadEmployees(this.value)">
                                    <option value="" disabled selected>Choose...</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="employee">Assign Employee(s)<span class="text-danger">*</span></label>
                                <select id="employee" name="employees[]" class="form-control" multiple required>
                                    <!-- Employee options will be populated dynamically -->
                                </select>
                                @error('employees')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="moderator">Assign Moderator<span class="text-danger">*</span></label>
                                <select id="moderator" name="moderator" class="form-control" required>
                                    <!-- Moderator options will be populated dynamically -->
                                </select>
                                @error('moderator')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="status">Status<span class="text-danger">*</span></label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="" disabled selected>Choose...</option>
                                    <option value="Dev">Dev</option>
                                    <option value="Live">Live</option>
                                </select>
                                @error('status')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="doi">Issued Date</label>
                                <input id="doi" name="date" class="form-control" type="date" value="{{ old('date') }}">
                                @error('date')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="url">URL</label>
                                <input id="url" class="form-control" type="text" name="url" value="{{ old('url') }}" placeholder="Enter URL">
                                @error('url')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="4" placeholder="Enter description">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-gradient-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function loadEmployees(departmentId) {
        // Clear previous data
        document.getElementById('employee').innerHTML = '';
        document.getElementById('moderator').innerHTML = '';

        fetch(`/admin/department/${departmentId}/employees`)
            .then(response => response.json())
            .then(data => {
                data.employees.forEach(employee => {
                    const option = new Option(employee.name, employee.id);
                    document.getElementById('employee').add(option);

                    const modOption = new Option(employee.name, employee.id);
                    document.getElementById('moderator').add(modOption);
                });
            });
    }
</script>
@endsection
