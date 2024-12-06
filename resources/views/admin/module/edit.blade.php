@extends('layout.admin.default')
@section('title', 'Edit Module')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Edit Module </h3>
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
                    <h4 class="card-title mb-4">Update Module</h4>
                    <form class="forms-sample" method="POST" action="{{ route('admin.modules.update', $module->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="project">Select Project<span class="text-danger">*</span></label>
                                <select id="project" name="project_id" class="form-control form-control-sm" required onchange="loadProjectEmployees(this.value)">
                                    <option value="" disabled>Choose...</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ $module->project_id == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <span class="error-message text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="module_name">Module Name<span class="text-danger">*</span></label>
                                <input id="module_name" class="form-control" type="text" name="name" value="{{ old('name', $module->name) }}" placeholder="Enter Module Name" required>
                                @error('name')
                                    <span class="error-message text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label for="employee-checkboxes">Assigned Employee(s)<span class="text-danger">*</span></label>
                                <div id="employee-checkboxes" class="checkit">
                                    @foreach($assignedEmployees as $assignment)
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                   class="form-check-input checkitto" 
                                                   id="employee-{{ $assignment->employee->id }}" 
                                                   name="employees[]" 
                                                   value="{{ $assignment->id }}" 
                                                
                                                   {{ in_array($assignment->id, $moduleAssignedEmployees) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="employee-{{ $assignment->employee->id }}">
                                                {{ $assignment->employee->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('employees')
                                    <span class="error-message text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            {{-- <div class="form-group col-md-6">
                                <label for="employee-checkboxes">Assign Employee(s)<span class="text-danger">*</span></label>
                                <div id="employee-checkboxes" class="checkit">
                                    @foreach($projectAssignments as $assignment)
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkitto" id="employee-{{ $assignment->employee->id }}" 
                                                name="employees[]" value="{{ $assignment->employee->id }}" 
                                                {{ in_array($assignment->employee->id, $module->details->pluck('assign_project.user_id')->toArray()) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="employee-{{ $assignment->employee->id }}">
                                                {{ $assignment->employee->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('employees')
                                    <span class="error-message text-danger">{{ $message }}</span>
                                @enderror
                            </div> --}}

                            <div class="form-group col-md-3">
                                <label for="start_date">Start Date<span class="text-danger">*</span></label>
                                <input id="start_date" name="start_date" class="form-control" type="date" value="{{ old('start_date', $module->start_date) }}" required>
                                @error('start_date')
                                    <span class="error-message text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-3">
                                <label for="end_date">End Date<span class="text-danger">*</span></label>
                                <input id="end_date" name="end_date" class="form-control" type="date" value="{{ old('end_date', $module->end_date) }}" required>
                                @error('end_date')
                                    <span class="error-message text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-gradient-success">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function loadProjectEmployees(projectId) {
    const employeeCheckboxContainer = document.getElementById('employee-checkboxes');
    employeeCheckboxContainer.innerHTML = '';

    try {
        const response = await fetch("{{ route('admin.modules.employee.list') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({ id: projectId })
        });

        const data = await response.json();

        if (response.ok) {
            data.employees.forEach(employee => {
                const checkboxWrapper = document.createElement('div');
                checkboxWrapper.className = 'form-check';

                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.className = 'form-check-input checkitto';
                checkbox.id = `employee-${employee.id}`;
                checkbox.value = employee.id;
                checkbox.name = 'employees[]';

                // Check if employee is already assigned
                const assignedEmployees = {{ json_encode($module->details->pluck('assign_project.user_id')->toArray()) }};
                if (assignedEmployees.includes(employee.id)) {
                    checkbox.checked = true;
                }

                const label = document.createElement('label');
                label.className = 'form-check-label';
                label.htmlFor = `employee-${employee.id}`;
                label.textContent = employee.name;

                checkboxWrapper.appendChild(checkbox);
                checkboxWrapper.appendChild(label);
                employeeCheckboxContainer.appendChild(checkboxWrapper);
            });
        } else {
            console.error('Failed to load employees:', data.message || 'Unknown error');
        }
    } catch (error) {
        console.error('Error fetching employees:', error);
    }
}
</script>
@endsection









