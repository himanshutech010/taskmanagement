


@extends('layout.admin.default')
@section('title', 'Create Task')
@section('content')

<div class="content-wrapper">
    <h2 class="mt-4">Create New Task</h2>

    <form action="{{ route('admin.task.store') }}" method="POST">
        @csrf

        <!-- Task Name -->
        <div class="form-group">
            <label for="name">Task Name</label>
            <input type="text" name="name" id="name" class="form-control"  value="{{ old('name') }}">
            @error('name')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Created Date -->
        <div class="form-group">
            <label for="created_date">Created Date</label>
            <input type="date" name="created_date" id="created_date" class="form-control"  value="{{ old('created_date') }}">
            @error('created_date')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Task Value Checklist -->
        <div id="taskValueContainer">
            <div class="input-group mb-2">
                {{-- <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="hidden" name="isactive[]" value="0">
                        <input type="checkbox" name="isactive[]" value="1" onchange="this.previousElementSibling.value = this.checked ? 1 : 0;">
                    </div>
                </div>
                <input type="text" name="taskValue[]" class="form-control" placeholder="Enter task value">
                <textarea class="form-control mt-2" name="commentValue[]" rows="2" placeholder="Enter comment value"></textarea> --}}
                <div class="input-group-append">
                    <button type="button" class="btn btn-success add-more">Add More</button>
                </div>
            </div>
        </div>

        <!-- High Priority -->
        <div class="form-group">
            <label for="highPriority">High Priority</label>
            <select name="highPriority" id="highPriority" class="form-control">
                <option value="1" {{ old('highPriority') == '1' ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('highPriority') == '0' ? 'selected' : '' }}>No</option>
            </select>
            @error('highPriority')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Deadline -->
        <div class="form-group">
            <label for="Deadline">Deadline</label>
            <input type="date" name="Deadline" id="Deadline" class="form-control" value="{{ old('Deadline') }}">
            @error('Deadline')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Toggle +More -->
        <div class="form-group">
            <button type="button" class="btn btn-primary" id="toggleMore">+More</button>
        </div>

        <!-- Additional Sections -->
        <div id="additionalSections" style="display: none;">
            <div class="form-group">
                <label for="project_id">Project</label>
                <select name="project_id" id="project_id" class="form-control" onchange="loadModulesAndEmployees(this.value)">
                    <option value="">Select a Project</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
                @error('project_id')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="Module_id">Module</label>
                <select name="Module_id" id="Module_id" class="form-control"></select>
                @error('Module_id')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="employeeContainer">Assign to Users</label>
                <div id="employeeContainer"></div>
                @error('userAssigneId')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group" id="fallbackUserAssign">
            <label for="userAssigneId">Assign to Users</label>
            <select name="userAssigneId[]" id="userAssigneId" class="form-control" multiple>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ in_array($user->id, old('userAssigneId', [])) ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('userAssigneId')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Task</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>//when checked store multiple and not checked store single//previousElementSibling// time please correcy this for only one time store in array chechked and not checked
$(document).on('click', '.add-more', function () {
    const newInput = `
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="hidden" name="isactive[]" value="1" >
                    <input type="checkbox" name="isactive[]" value="0" onchange="this.value = this.checked ? 0 : 1;">
                </div>
            </div>
            <input type="text" name="taskValue[]" class="form-control" placeholder="Enter task value">
            <textarea class="form-control mt-2" name="commentValue[]" rows="2" placeholder="Enter comment value"></textarea>
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove">Remove</button>
            </div>
        </div>`;
    $('#taskValueContainer').append(newInput); // //  <input type="hidden" name="isactive[]" value="1">
});

$(document).on('click', '.remove', function () {
    $(this).closest('.input-group').remove();
});

document.getElementById('toggleMore').addEventListener('click', function () {
    const additionalSections = document.getElementById('additionalSections');
    const fallbackUserAssign = document.getElementById('fallbackUserAssign');

    const isHidden = additionalSections.style.display === 'none';
    additionalSections.style.display = isHidden ? 'block' : 'none';
    fallbackUserAssign.style.display = isHidden ? 'none' : 'block';
});

async function loadModulesAndEmployees(projectId) {
    const moduleSelect = document.getElementById('Module_id');
    const employeeContainer = document.getElementById('employeeContainer');

    moduleSelect.innerHTML = '<option value="">Select a Module</option>';
    employeeContainer.innerHTML = '';

    if (!projectId) return;

    try {
        const response = await fetch("{{ route('admin.task.module.list') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            body: JSON.stringify({ project_id: projectId })
        });

        const data = await response.json();
        if (response.ok) {
            data.modules.forEach(module => {
                const option = document.createElement('option');
                option.value = module.id;
                option.textContent = module.name;
                moduleSelect.appendChild(option);
            });

            moduleSelect.addEventListener('change', async function () {
                const moduleId = this.value;
                if (!moduleId) return;

                const employeeResponse = await fetch("{{ route('admin.task.employee.list') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({ project_id: projectId, module_id: moduleId })
                });

                const employeeData = await employeeResponse.json();
                if (employeeResponse.ok) {
                    employeeContainer.innerHTML = '';
                    employeeData.employees.forEach(employee => {
                        const checkbox = `
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="employee_${employee.id}" name="userAssigneId[]" value="${employee.id}">
                                <label class="form-check-label" for="employee_${employee.id}">${employee.name}</label>
                            </div>`;
                        employeeContainer.innerHTML += checkbox;
                    });
                } else {
                    console.error('Error loading employees:', employeeData.message);
                }
            });
        } else {
            console.error('Error loading modules:', data.message);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}
</script>
@endsection
