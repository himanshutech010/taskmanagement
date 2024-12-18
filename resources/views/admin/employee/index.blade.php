<!-- Add in the <head> -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Add before the closing </body> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


@extends('layout.admin.default')
@section('title', 'Users')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title "> Employee Data </h3>

            @if (in_array(auth()->user()->role, ['Super Admin']))
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.employee.create') }}" class="btn btn-block btn-lg btn-gradient-success">+
                                Add Employee</a>
                        </li>
                    </ol>
                </nav>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Emp ID</th>
                                    <th>Name</th>
                                    <th>Email id</th>

                                    <th>Role</th>
                                    <th>Departments</th>
                                    <th>Status</th>
                                    @if (in_array(auth()->user()->role, ['Super Admin']))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $employee)
                                    <tr>
                                        <td><a href="#" class="view-employee-details" data-id="{{ $employee->id }}"
                                                data-toggle="modal" data-target="#employeeDetailsModal"
                                                style="color:green;text-decoration: none;">
                                                {{ $employee->staff_id }}
                                            </a></td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->email }}</td>

                                        <td>{{ $employee->role }}</td>
                                        <td>
                                            <!-- View Departments Modal Trigger -->
                                            <button class="btn btn-sm btn-gradient-success" data-toggle="modal"
                                                data-target="#viewDepartmentsModal{{ $employee->id }}">
                                                View Dept.
                                            </button>
                                        </td>
                                        <td>
                                            <a href="#" class="toggle-status" data-id="{{ $employee->id }}"
                                                data-status="{{ $employee->status }}">
                                                <span
                                                    class="badge badge-rounded {{ $employee->status == 1 ? 'badge-success' : 'badge-danger' }}"
                                                    style="border-radius: 20px;">
                                                    {{ $employee->status == 1 ? 'Active' : 'Inactive' }}
                                                </span>
                                            </a>
                                        </td>
                                        @if (in_array(auth()->user()->role, ['Super Admin']))
                                            <td>
                                                <button type="button" class="btn btn-inverse-dark btn-icon">
                                                    <a href="{{ route('admin.employee.edit', $employee->id) }}"><i
                                                            class="mdi mdi-account-edit btn-icon-append"
                                                            style="color:black;font-size:20px;"></i></a>
                                                </button>

                                                <form action="{{ route('admin.employee.destroy', $employee->id) }}"
                                                    method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-inverse-dark  btn-icon"
                                                        onclick="return confirm('Are you sure you want to delete this employee?')"><i
                                                            class="mdi mdi-delete" style="font-size: 20px;"></i></button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>

                                    <!-- View Departments Modal -->
                                    <div class="modal fade" id="viewDepartmentsModal{{ $employee->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="viewDepartmentsModalLabel{{ $employee->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="viewDepartmentsModalLabel{{ $employee->id }}">Departments for
                                                        {{ $employee->name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <ul>
                                                        @forelse($employee->departments as $department)
                                                            <li> <span style="color:green;">{{ $department->name }}</span>
                                                            </li>
                                                        @empty
                                                            <span style="color:red;">No departments assigned.</span>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-gradient-success"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->
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

        $(document).ready(function() {
            $('.toggle-status').on('click', function(e) {
                e.preventDefault();
                const employeeId = $(this).data('id');
                const currentStatus = $(this).data('status');

                $.ajax({
                    url: "{{ url('admin/employee/toggle-status') }}",
                    method: 'POST',
                    data: {
                        id: employeeId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            const statusBadge = $('a[data-id="' + employeeId + '"] span');

                            // Update status text and class
                            statusBadge.text(response.statusText);
                            statusBadge.removeClass('badge-success badge-danger').addClass(
                                response.statusClass);

                            // Update the data attribute
                            $('a[data-id="' + employeeId + '"]').data('status', response
                                .newStatus);
                        }
                    },
                    error: function() {
                        alert('Failed to toggle status.');
                    }
                });
            });
        });
    </script>
@endsection
