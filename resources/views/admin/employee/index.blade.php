<!-- Add in the <head> -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add before the closing </body> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


@extends('layout.admin.default')
@section('title','Users')
@section('content')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title "> Employee Data </h3>
     
        @if (in_array(auth()->user()->role, ['Super Admin']))
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.employee.create') }}" class="btn btn-block btn-lg btn-gradient-success">+ Add Employee</a>
                </li>
            </ol>
        </nav>
        @endif
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Employee Table</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Emp ID</th>
                                <th>Name</th>
                                <th>Email id</th>
                                <th>Phone No.</th>
                                <th>Role</th>
                                <th>Departments</th>
                                <th>Status</th>
                                @if (in_array(auth()->user()->role, ['Super Admin']))                                   
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $employee)
                                <tr>
                                    <td>{{ $employee->staff_id }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->phone }}</td>
                                    <td>{{ $employee->role}}</td>
                                    <td>
                                        <!-- View Departments Modal Trigger -->
                                        <button class="btn btn-sm btn-gradient-success" data-toggle="modal" data-target="#viewDepartmentsModal{{ $employee->id }}">
                                            View Dept.
                                        </button>
                                    </td>
                                    <td>
                                        <span class="badge badge-rounded {{ $employee->status == 1 ? 'badge-success' : 'badge-danger' }}" style="border-radius: 20px; ">
                                            {{ $employee->status == 1 ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    @if (in_array(auth()->user()->role, ['Super Admin']))
                                   
                                   
                                    <td>
                                        <a href="{{ route('admin.employee.edit', $employee->id) }}" class="btn btn-inverse-dark "><i class="mdi mdi-account-edit btn-icon-append"></i>Edit</a>
                                        <form action="{{ route('admin.employee.destroy', $employee->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-inverse-dark  btn-icon" onclick="return confirm('Are you sure you want to delete this employee?')"><i class="mdi mdi-delete" style="font-size: 20px;"></i></button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>

                                <!-- View Departments Modal -->
                                <div class="modal fade" id="viewDepartmentsModal{{ $employee->id }}" tabindex="-1" role="dialog" aria-labelledby="viewDepartmentsModalLabel{{ $employee->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewDepartmentsModalLabel{{ $employee->id }}">Departments for {{ $employee->name }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <ul>
                                                    @forelse($employee->departments as $department)
                                                        <li>{{ $department->name }}</li>
                                                    @empty
                                                        <li>No departments assigned.</li>
                                                    @endforelse
                                                </ul>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-gradient-danger" data-dismiss="modal">Close</button>
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

@endsection
