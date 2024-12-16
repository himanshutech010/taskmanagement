
@extends('layout.admin.default')

@section('title', 'Edit Project')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Edit Project</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-gradient-success btn-lg">Back</a>
                </li>
            </ol>
        </nav>
    </div>
    
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Update Project Details</h4>
                    <form class="forms-sample" method="POST" action="{{ route('admin.project.update', $project->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') 
                        
                        <div class="row">
                            <!-- Project Name -->
                            <div class="form-group col-md-6">
                                <label for="name">Project Name<span class="text-danger">*</span></label>
                                <input id="name" name="name" type="text" class="form-control" 
                                    value="{{ old('name', $project->name) }}" placeholder="Enter Project Name" >
                                    @error('name')
                                    <span class="error-message text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Client -->
                            <div class="form-group col-md-6">
                                <label for="client">Client<span class="text-danger">*</span></label>
                                <select id="client" name="client_id" class="form-control form-control-sm" >
                                    <option value="" disabled>Choose...</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}" {{ old('client_id', $project->client_id) == $client->id ? 'selected' : '' }} >
                                            {{ $client->client_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <span class="error-message text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Department -->
                            <div class="form-group col-md-6">
                                <label for="department">Department<span class="text-danger">*</span></label>
                                <select id="department" name="department_id" class="form-control form-control-sm" required onchange="loadEmployees(this.value)">
                                    <option value="" disabled>Choose...</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id', $project->department_id) == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <span class="error-message text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Employees -->
                            <div class="form-group col-md-6">
                                <label>Assign Employee(s)<span class="text-danger">*</span></label>
                      
                                    <div id="employee-checkboxes" class="checkit">
                                    @foreach($assignedEmployees as $employee)
                                    @php
                                 
                                    $emp = $assinProjects->where('project_id', $project->id)->where('user_id',$employee )->first()?->employee;
                                    // $emp=$emp->where('isdeleted', 0);
                                   // dd($emp);
                                     @endphp
                                    {{-- {{dd( $employee)}} --}}
                                    @if ($emp->isdeleted==0)
                                  
                                    @if ($emp->status==0)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="employee-{{ $employee }}" 
                                            name="employees[]" value="{{ $employee }}" onchange="updateModeratorDropdown()"
                                         
                                            {{ in_array($employee, old('employees', $assignedEmployees)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="employee-{{ $employee }}"><span class="text-danger">{{ $emp->name}}->Inactive</span></label>
                                    </div>  
                                    @else  
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="employee-{{ $employee }}" 
                                            name="employees[]" value="{{ $employee }}" onchange="updateModeratorDropdown()"
                                         
                                            {{ in_array($employee, old('employees', $assignedEmployees)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="employee-{{ $employee }}">{{ $emp->name}}</label>
                                    </div>

                                    @endif
                                      
                                        @endif
                                    @endforeach
                                    </div>
                                @error('employees')
                                    <span class="error-message text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Moderator -->
                            <div class="form-group col-md-6">
                                <label for="moderator">Assign Moderator<span class="text-danger">*</span></label>
                                <select id="moderator" name="moderator" class="form-control form-control-sm" required>
                                    {{-- @php
                                    $moderator = $assinProjects->where('project_id', $project->id)->where('is_moderator', true)->first()?->employee;
                                @endphp --}}
                                    @foreach($project->assignments as $assignment)
                                    @if ($assignment->employee->status==0)
                                    <option  class="text-danger" value="{{ $assignment->user_id }}"  {{ old('moderator', $moderator->id) == $assignment->user_id ? 'selected' : '' }}>
                                 {{ $assignment->employee->name }}->Inactive
                                    </option>  
                                    @else  
                                    <option value="{{ $assignment->user_id }}" {{ old('moderator', $moderator->id) == $assignment->user_id ? 'selected' : '' }}>
                                        {{ $assignment->employee->name }}
                                    </option>

                                    @endif
                                       
                                    @endforeach
                                </select>
                                @error('moderator')
                                    <span class="error-message text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="form-group col-md-6">
                                <label for="status">Status<span class="text-danger">*</span></label>
                                <select id="status" name="status" class="form-control form-control-sm" required>
                                    <option value="Dev" {{ old('status', $project->status) == 'Dev' ? 'selected' : '' }}>Dev</option>
                                    <option value="Live" {{ old('status', $project->status) == 'Live' ? 'selected' : '' }}>Live</option>
                                </select>
                                @error('status')
                                    <span class="error-message text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Date -->
                            <div class="form-group col-md-6">
                                <label for="doi">Issued Date</label>
                                <input id="doi" name="date" type="date" class="form-control" 
                                    value="{{ old('date', $project->date) }}">
                                @error('date')
                                    <span class="error-message text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- URL -->
                            <div class="form-group col-md-6">
                                <label for="url">URL</label>
                                <input id="url" name="url" type="text" class="form-control" 
                                    value="{{ old('url', $project->url) }}" placeholder="Enter URL">
                                @error('url')
                                    <span class="error-message text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $project->description) }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-gradient-success">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  async function loadEmployees(departmentId) {
    const employeeCheckboxContainer = document.getElementById('employee-checkboxes');
    const moderatorSelect = document.getElementById('moderator');

   
    employeeCheckboxContainer.innerHTML = '';
    moderatorSelect.innerHTML = '';

    try {
        const response = await fetch("{{ route('admin.project.employee.list') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({ id: departmentId })
        });

        const data = await response.json();

        if (response.ok) {
            // Populate employee checkboxes
            data.employees.forEach(employee => {
                const checkboxWrapper = document.createElement('div');
                checkboxWrapper.className = 'form-check';

                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.className = 'form-check-input checkitto';
                checkbox.id = `employee-${employee.id}`;
                checkbox.value = employee.id;
                checkbox.name = 'employees[]';
                checkbox.addEventListener('change', updateModeratorDropdown);

                const label = document.createElement('label');
                label.className = 'form-check-label';
                label.htmlFor = `employee-${employee.id}`;
                label.textContent = employee.name;

                checkboxWrapper.appendChild(checkbox);
                checkboxWrapper.appendChild(label);
                employeeCheckboxContainer.appendChild(checkboxWrapper);
            });
        } else {
            console.error('Failed to load employees:', data.message);
        }
    } catch (error) {
        console.error('Error fetching employees:', error);
    }
}

function updateModeratorDropdown() {
    const employeeCheckboxContainer = document.getElementById('employee-checkboxes');
    const moderatorSelect = document.getElementById('moderator');

    // Clear previous options in Moderator dropdown
    moderatorSelect.innerHTML = '';

    // Get all checked employees and populate Moderator dropdown
    const selectedCheckboxes = employeeCheckboxContainer.querySelectorAll('input[type="checkbox"]:checked');
    selectedCheckboxes.forEach(checkbox => {
        const option = document.createElement('option');
        option.value = checkbox.value;
        option.textContent = checkbox.nextElementSibling.textContent; 
        moderatorSelect.appendChild(option);
    });
}
</script>
@endsection





