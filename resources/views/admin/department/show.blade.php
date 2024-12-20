<!-- Add in the <head> -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Add before the closing </body> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@extends('layout.admin.default')
@section('title', 'Department Details')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">{{ $department->name }}</h3>

            @if (in_array(auth()->user()->role, ['Super Admin']))
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <button class="btn btn-lg btn-outline-success" data-toggle="modal"
                                data-target="#assignEmployeeModal">
                                + Assign an Employee
                            </button>
                        </li>
                    </ol>
                </nav>
            @endif
        </div>

        <!-- Assign Employee Modal -->
        <div class="modal fade" id="assignEmployeeModal" tabindex="-1" role="dialog"
            aria-labelledby="assignEmployeeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignEmployeeModalLabel">Assign Employee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('admin.department.assign', $department->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="user_id">Select User</label>
                                <select name="user_id" id="user_id" class="form-control form-control-sm" required>
                                    <option value="" disabled selected>Select a user</option>
                                    @foreach ($unassignedUsers as $user)
                                        @if ($user->role != 'Super Admin')
                                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->staff_id }})
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="submit" class="btn btn-gradient-success">Assign</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Employee Table -->
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Emp ID</th>
                                    <th>Name</th>
                                    <th>Email ID</th>

                                    <th>Phone No.</th>
                                    @if (in_array(auth()->user()->role, ['Super Admin']))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($department->users as $employee)
                                    <tr>
                                        <td><a href="#" class="view-employee-details" data-id="{{ $employee->id }}"
                                                data-toggle="modal" data-target="#employeeDetailsModal"
                                                style="color:green;text-decoration: none;font-weight: bold;">
                                                {{ $employee->staff_id }}
                                            </a></td>
                                        @if ($employee->status == 0)
                                            <td>{{ $employee->name }}<span class="inactive-badge">Inactive</span></span></td>
                                        @else
                                            <td>{{ $employee->name }}</td>
                                        @endif

                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->phone }}</td>
                                        @if (in_array(auth()->user()->role, ['Super Admin']))
                                            <td>
                                                <button type="button" class="btn btn-inverse-dark btn-icon">
                                                    <a href="{{ route('admin.employee.edit', $employee->id) }}"><i
                                                            class="mdi mdi-account-edit btn-icon-append"
                                                            style="color:black;font-size:20px;"></i></a>
                                                </button> 
                                                <form
                                                    action="{{ route('admin.department.remove', ['departmentId' => $department->id, 'userId' => $employee->id]) }}"
                                                    method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-inverse-dark  btn-icon btn-sm"
                                                        onclick="return confirm('Are you sure you want to remove this employee?')"><i
                                                            class="mdi mdi-delete" style="font-size: 20px;"></i></button>
                                                </form>

                                            </td>
                                        @endif
                                    </tr>
                                       <!-- Employee Details Modal -->
                                    <div class="modal fade" id="employeeDetailsModal" tabindex="-1" role="dialog"
                                        aria-labelledby="employeeDetailsModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="employeeDetailsModalLabel">Employee Details
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" id="employee-details-content">
                                                    Loading...
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-gradient-success"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->
                                @endforeach
                            </tbody>
                        </table>

                        @if ($department->users->isEmpty())
                            <p class="text-center">No employees assigned to this department.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

   <script>
        $(document).ready(function() {
            $('.view-employee-details').on('click', function() {
                const employeeId = $(this).data('id');

                // Clear previous content
                $('#employee-details-content').html('Loading...');

                // AJAX request
                $.ajax({
                    url: "{{ url('admin/employee') }}/" + employeeId,
                    method: 'GET',
                    success: function(response) {
                        $('#employee-details-content').html(response);
                    },
                    error: function() {
                        $('#employee-details-content').html(
                            '<p class="text-danger">Failed to load details.</p>');
                    }
                });
            });
        });

    </script>
@endsection
