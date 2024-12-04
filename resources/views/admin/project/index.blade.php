<!-- Add in the <head> -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Add before the closing </body> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



@extends('layout.admin.default')
@section('title', 'Projects')
@section('content')


<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Project Data</h3>
        @if (in_array(auth()->user()->role, ['Super Admin']))
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.projects.create') }}" class="btn btn-block btn-lg btn-gradient-success">
                        + Add Project
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
                    <h4 class="card-title mb-4">Project List</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Client</th>
                                <th>Departments</th>
                                <th>URL</th>
                                <th>Moderator</th>
                                <th>Team</th>
                                <th>Start Date</th>
                                <th>Status</th>
                                @if (in_array(auth()->user()->role, ['Super Admin']))                                   
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                                <tr>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ $project->client_name}}</td>
                                    <td>{{ $project->dept_name }}</td>
                                    <td>{{ $project->url}}</td>
                                    <td>{{ $project->moderator }}</td>
                                    <td>
                                        <!-- View Team Modal Trigger -->
                                        <button class="btn btn-sm btn-gradient-success" data-toggle="modal" data-target="#viewProjectModal{{ $project->id }}">
                                            View Team
                                        </button>
                                    </td>
                                    <td>{{ $project->started_date }}</td>
                                    <td>{{ $project->status}}</td>
                                    
                                    <td>
                                        <span class="badge {{ $project->status == 1 ? 'badge-success' : 'badge-danger' }}">
                                            {{ $project->status == 1 ? 'DEV' : 'LIVE' }}
                                        </span>
                                    </td>
                                    @if (in_array(auth()->user()->role, ['Super Admin']))
                                   
                                   
                                    <td>
                                        <a href="" class="btn btn-inverse-dark "><i class="mdi mdi-account-edit btn-icon-append"></i>Edit</a>
                                        <form action="" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-inverse-dark  btn-icon" onclick="return confirm('Are you sure you want to delete this project?')"><i class="mdi mdi-delete" style="font-size: 20px;"></i></button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>

                                <!-- View Project Modal -->
                                <div class="modal fade" id="viewProjectModal{{ $project->id }}" tabindex="-1" role="dialog" aria-labelledby="viewProjectModalLabel{{ $project->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="viewProjectModalLabel{{ $project->id }}">Teams for {{ $project->name }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <ul>
                                                    @forelse($project->users as $user)
                                                        <li>{{ $user->name }}</li>
                                                    @empty
                                                        <li>No Employee assigned.</li>
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