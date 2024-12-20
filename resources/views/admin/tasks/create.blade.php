@extends('layout.admin.default')
@section('title', 'Create Task')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Create an Task </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.task.index') }}" class="btn btn-block btn-lg btn-gradient-success">Back</a>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Task</h2>
                        <form class="forms-sample" action="{{ route('admin.task.store') }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            <div class="row mb">
                                <!-- Task Name -->
                                <div class="form-group col-md-10">
                                    <label for="task_name">Task Name</label>
                                    <input type="text" name="task_name" id="task_name" class="form-control"
                                        value="{{ old('task_name') }}">
                                    @error('task_name')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2 highprior">
                                    <div class="form-check">
                                        <label class="form-check-label " for="highPriority">
                                            <input type="checkbox" class="form-check-input"
                                                style="border: solid #629a43"type="checkbox" name="highPriority"
                                                id="highPriority" value="1"
                                                {{ old('highPriority') == '1' ? 'checked' : '' }}>
                                            High Priority
                                        </label>
                                        <input type="hidden" name="highPriority" value="0">
                                    </div>
                                </div>
                            </div>
                            <!-- Created Date -->
                            <div class="row mb">
                                <div class="form-group col-md-12">
                                    <div id="checklist_nameContainer">
                                        <div class="input-group mb-2">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-gradient-success add-more">Add
                                                    Checklist</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </div>

                            <!-- Task Value Checklist -->
                            <div class="row mb">
                                <div class="form-group col-md-6">
                                    <label for="created_date">Created Date</label>
                                    <input type="date" name="created_date" id="created_date" class="form-control"
                                        value="{{ old('created_date') }}">
                                    @error('created_date')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Deadline -->
                                <div class="form-group col-md-6">
                                    <label for="Deadline">Deadline</label>
                                    <input type="date" name="Deadline" id="Deadline" class="form-control"
                                        value="{{ old('Deadline') }}">
                                    @error('Deadline')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Toggle +More -->
                            <div class="row mb">
                                <div class="form-group col-md-6">
                                    <button type="button" class="btn btn-outline-success" id="toggleMore">+More Details</button>
                                </div>
                            </div>
                            <!-- Additional Sections -->
                            <div id="additionalSections" style="display: none;">
                              <div class="row mb">
                                <div class="form-group col-md-6">
                                    <label for="project_id">Project</label>
                                    <select name="project_id" id="project_id"  class="form-control form-control-sm"
                                        onchange="loadModulesAndEmployees(this.value)">
                                        <option value="">Select a Project</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}"
                                                {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="Module_id">Module</label>
                                    <select name="Module_id" id="Module_id"  class="form-control form-control-sm"></select>
                                    @error('Module_id')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
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
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ in_array($user->id, old('userAssigneId', [])) ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('userAssigneId')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-gradient-success">Create Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        //when checked store multiple and not checked store single//previousElementSibling// time please correcy this for only one time store in array chechked and not checked
        $(document).on('click', '.add-more', function() {
            const newInput = `
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="hidden" name="isactive[]" value="1" >
                    <input type="checkbox" name="isactive[]" value="0" onchange="this.value = this.checked ? 0 : 1;">
                </div>
            </div>
            <input type="text" name="checklist_name[]" class="form-control" placeholder="Enter Checklist">
            <textarea class="form-control mt-2" name="commentValue[]" rows="2" placeholder="Enter comment value"></textarea>
            <div class="input-group-append">
                <button type="button" class="btn btn-danger remove">Remove</button>
            </div>
        </div>`;
            $('#checklist_nameContainer').append(newInput); // //  <input type="hidden" name="isactive[]" value="1">
        });

        $(document).on('click', '.remove', function() {
            $(this).closest('.input-group').remove();
        });

        document.getElementById('toggleMore').addEventListener('click', function() {
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
                    body: JSON.stringify({
                        project_id: projectId
                    })
                });

                const data = await response.json();
                if (response.ok) {
                    data.modules.forEach(module => {
                        const option = document.createElement('option');
                        option.value = module.id;
                        option.textContent = module.name;
                        moduleSelect.appendChild(option);
                    });

                    moduleSelect.addEventListener('change', async function() {
                        const moduleId = this.value;
                        if (!moduleId) return;

                        const employeeResponse = await fetch("{{ route('admin.task.employee.list') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            },
                            body: JSON.stringify({
                                project_id: projectId,
                                module_id: moduleId
                            })
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
