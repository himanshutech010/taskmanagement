
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

        @if (in_array(auth()->user()->role, ['Super Admin', 'Manager']))
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <button class="btn btn-block btn-lg btn-gradient-primary" data-toggle="modal" data-target="#assignEmployeeModal">
                            + Assign an Employee
                        </button>
                    </li>
                </ol>
            </nav>
        @endif
    </div>

    <!-- Assign Employee Modal -->
    <div class="modal fade" id="assignEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="assignEmployeeModalLabel" aria-hidden="true">
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
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="" disabled selected>Select a user</option>
                                @foreach($unassignedUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Assign</button>
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
                    <h4 class="card-title">{{ $department->name }} -> Employee Table</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email ID</th>
                                
                                <th>Phone No.</th>
                                @if (in_array(auth()->user()->role, ['Super Admin']))
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($department->users as $employee)
                                <tr>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->phone }}</td>
                                    @if (in_array(auth()->user()->role, ['Super Admin']))
                                    <td>
                                        <a href="{{ route('admin.employee.edit', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        {{-- <form action="{{ route('admin.department.remove', $employee->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this employee?')">Remove</button>
                                        </form> --}}
                                        <form action="{{ route('admin.department.remove', ['departmentId' => $department->id, 'userId' => $employee->id]) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this employee?')">Remove</button>
                                        </form>
                                        
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($department->users->isEmpty())
                        <p class="text-center">No employees assigned to this department.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


 