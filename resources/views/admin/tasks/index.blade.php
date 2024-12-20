<!-- Add in the <head> -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Add before the closing </body> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@extends('layout.admin.default')
@section('title', 'Tasks')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Tasks</h3>
            @if (in_array(auth()->user()->role, ['Super Admin', 'Manager']))
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.task.create') }}" class="btn btn-block btn-lg btn-gradient-success">
                                + Add Task
                            </a>
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
                                    <th>Task Name</th>
                                    <th>Created Date</th>
                                    <th>High Priority</th>
                                    <th>Deadline</th>
                                    <th>Assigned Users</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td>{{ $task->name }}</td>
                                        <td>{{ $task->created_date }}</td>
                                        <td>{{ $task->highPriority ? 'Yes' : 'No' }}</td>
                                        <td>{{ $task->Deadline ? $task->Deadline : 'N/A' }}</td>
                                        <td>
                                            @foreach ($task->assignedUsers as $user)
                                                <span class="badge badge-primary">{{ $user->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.task.edit', $task->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('admin.task.destroy', ['id' => $task->id]) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
