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

    <!-- Display success message -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Task Table -->
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Task List</h4>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Task Name</th>
                            <th>Created Date</th>
                            <th>High Priority</th>
                            <th>Deadline</th>
                            <th>Assigned Users</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $task->name }}</td>
                            <td>{{ $task->created_date }}</td>
                            <td>{{ $task->highPriority ? 'Yes' : 'No' }}</td>
                            {{-- <td>{{ $task->Deadline ? $task->Deadline->format('Y-m-d') : 'N/A' }}</td> --}}
                            <td>{{ $task->Deadline ? $task->Deadline : 'N/A' }}</td>
                            <td>
                                @foreach($task->assignedUsers as $user)
                                    <span class="badge badge-primary">{{ $user->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('admin.task.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.task.destroy', ['id'=>  $task->id]) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No tasks available.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection