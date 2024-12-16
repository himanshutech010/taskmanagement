@extends('layout.admin.default')

@section('title', 'Edit Task')

@section('content')
<div class="content-wrapper">
    <h2 class="mt-4">Edit Task</h2>

    <form action="{{ route('admin.task.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Task Name -->
        <div class="form-group">
            <label for="name">Task Name</label>
            <input type="text" name="name" id="name" class="form-control"   value="{{ old('name', $task->name) }}">
            @error('name')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Created Date -->
        <div class="form-group">
            <label for="created_date">Created Date</label>
            <input 
                type="date" 
                name="created_date" 
                id="created_date" 
                class="form-control" 
                required 
                value="{{ old('created_date', $task->created_date ? \Carbon\Carbon::parse($task->created_date)->format('Y-m-d') : '') }}">
            @error('created_date')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Task Value Checklist -->
        <div class="form-group">
            <label for="taskValue">Task Value Checklist</label>
            <div id="taskValueContainer">
                @foreach ($taskCheckList as $checklist)
                {{-- {{dd( $checklist);}} --}}
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            {{-- <div class="input-group-text"> --}}
                              
                                {{-- {{dd($checklist->id);}} --}}

                                {{-- <input type="hidden" name="taskCheckListIdd[]" value="{{ $checklist->id }}"> --}}
                                {{-- <input type="checkbox" name="isactive[]" value="1" {{ $checklist->isactive ? 'checked' : '' }}> --}}
                                {{-- <input type="checkbox" name="isactive[]" value="{{ old('isactive'.$loop->index, $checklist->isactive ? 'checked' : '')}}" onchange="this.value = this.checked ? 0 : 1;"> --}}
                            {{-- </div> --}}
                            <div class="input-group-text">
                                {{-- Hidden input to store the checklist ID --}}
                                <input type="hidden" name="taskCheckListIdd[]" value="{{ $checklist->id }}">
                            
                                {{-- Checkbox for isactive --}}
                                <input type="checkbox" 
                                       name="isactive[{{ $loop->index }}]" 
                                       value="1" 
                                       {{ $checklist->isactive ? 'checked' : '' }} 
                                       onchange="this.checked ? this.value = 1 : this.value = 0;">
                            </div>
                            
                        </div>
                        <input type="text" name="taskValue[]" class="form-control" value="{{ old('taskValue.' . $loop->index , $checklist->taskValue) }}">
                        
                        @php
                            $com = $comment->firstWhere('taskCheckListId', $checklist->id);
                        @endphp
                        <div class="form-group mt-2">
                            <input type="hidden" name="commentValueId[]" value="{{ $com->id ?? '' }}">
                            <textarea name="commentValue[]" class="form-control" rows="2" placeholder="Enter comment">{{ $com->commentValue ?? '' }}</textarea>
                        
                        </div>
        
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger remove">Remove</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-success add-more">Add More</button>
        </div>
        
        <!-- High Priority -->
        <div class="form-group">
            <label for="highPriority">High Priority</label>
            <select name="highPriority" id="highPriority" class="form-control">
                <option value="1" {{ old('highPriority', $task->highPriority) == '1' ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('highPriority', $task->highPriority) == '0' ? 'selected' : '' }}>No</option>
            </select>
            @error('highPriority')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Deadline -->
        <div class="form-group">
            <label for="Deadline">Deadline (Optional)</label>
            <input 
                type="date" 
                name="Deadline" 
                id="Deadline" 
                class="form-control" 
                value="{{ old('Deadline', $task->Deadline ? \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') : '') }}">
            @error('Deadline')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Project ID -->
        <div class="form-group">
            <label for="project_id">Project</label>
            <select name="project_id" id="project_id" class="form-control" required  onchange="loadModulesAndEmployees(this.value)">
                <option value="">Select a Project</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                @endforeach
            </select>
            @error('project_id')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Module ID -->
        <div class="form-group">
            <label for="Module_id">Module</label>
            <select name="Module_id" id="Module_id" class="form-control" required>
                <option value="">Select a Module</option>
                @foreach ($modules as $module)
                    <option value="{{ $module->id }}" {{ old('Module_id', $task->Module_id) == $module->id ? 'selected' : '' }}>{{ $module->name }}</option>
                @endforeach
            </select>
            @error('Module_id')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Assign to Users -->
        <div class="form-group">
            <label for="employeeContainer">Assign to Users</label>
            <div id="employeeContainer">
                @if($task->assignedUsers)
                    @foreach($task->assignedUsers as $employee)
                        <div class="form-check">
                            <input type="checkbox" id="employee_{{ $employee->id }}" name="userAssigneId[]" value="{{ $employee->id }}" {{ in_array($employee->id, $task->assignedUsers->pluck('id')->toArray()) ? 'checked' : '' }}>
                            <label for="employee_{{ $employee->id }}">{{ $employee->name }}</label>
                        </div>
                    @endforeach
                @endif
            </div>
            @error('userAssigneId')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Task</button>
        </div>
    </form>
</div>

<script>
$(document).on('click', '.add-more', function () {
    const newInput = `
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="checkbox" name="isactive[]" value="1">
                </div>
            </div>
            <input type="text" name="taskValue[]" class="form-control" placeholder="Enter task value">
            <div class="form-group mt-2">
                <textarea name="commentValue[]" class="form-control" rows="2" placeholder="Enter comment"></textarea>
            </div>
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove">Remove</button>
            </div>
        </div>`;
    $('#taskValueContainer').append(newInput);
});

$(document).on('click', '.remove', function () {
    $(this).closest('.input-group').remove();
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
                    // Clear previous checkboxes
                    employeeContainer.innerHTML = '';

                    employeeData.employees.forEach(employee => {
                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        checkbox.id = `employee_${employee.id}`;
                        checkbox.name = 'userAssigneId[]';
                        checkbox.value = employee.id;

                        const label = document.createElement('label');
                        label.htmlFor = `employee_${employee.id}`;
                        label.textContent = employee.name;

                        const div = document.createElement('div');
                        div.classList.add('form-check');
                        div.appendChild(checkbox);
                        div.appendChild(label);

                        employeeContainer.appendChild(div);
                    });
                } else {
                    console.error('Error loading employees:', employeeData.message);
                }
            });
        } else {
            console.error('Failed to load modules:', data.message || 'Unknown error');
        }
    } catch (error) {
        console.error('Error fetching modules and employees:', error);
    }
}
</script>
@endsection
