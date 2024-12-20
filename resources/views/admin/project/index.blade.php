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
                                    @if (in_array(auth()->user()->role, ['Super Admin', 'Manager']))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>

                                        <td> <a href="#" class="view-project-details" data-id="{{ $project->id }}"
                                                data-toggle="modal" data-target="#projectDetailsModal"
                                                style="color:green;text-decoration: none;font-weight: bold;">
                                                {{ $project->name }}
                                            </a></td>
                                        <td>{{ $project->client->client_name }}</td>
                                        @php
                                            $department = $assinProjects->where('project_id', $project->id)->first()
                                                ?->department;
                                        @endphp
                                        <td>{{ $department->name }}</td>
                                        <td>
                                            @if ($project->url)
                                                <a class="btn-link" href="{{ $project->url }}" target="_blank"
                                                    style="font-weight: 600;font-size:15px">Link
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        @php
                                            $moderator = $assinProjects
                                                ->where('project_id', $project->id)
                                                ->where('is_moderator', true)
                                                ->first()?->employee;
                                        @endphp
                                        <td>{{ $moderator->name ?? 'N/A' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-gradient-success" data-toggle="modal"
                                                data-target="#viewTeamModal{{ $project->id }}">
                                                View Team
                                            </button>
                                        </td>
                                        <td>{{ $project->date ? $project->date->format('d-m-Y') : 'N/A'  }}</td>

                                        <td>
                                            <span
                                                class="badge {{ $project->status == 'Dev' ? 'badge-danger' : 'badge-success' }}"
                                                style="font-size:14px;">
                                                {{ $project->status == 'Dev' ? 'DEV' : 'LIVE' }}
                                            </span>
                                        </td>
                                        @if (in_array(auth()->user()->role, ['Super Admin', 'Manager']))
                                            <td>
                                                <button type="button" class="btn btn-inverse-dark btn-icon">
                                                    <a href="{{ route('admin.project.edit', $project->id) }}"><i
                                                            class="mdi mdi-account-edit btn-icon-append"
                                                            style="color:black;font-size:20px;"></i></a>
                                                </button>
                                                @if (in_array(auth()->user()->role, ['Super Admin']))
                                                    <form action="{{ route('admin.project.destroy', $project->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-inverse-dark btn-icon"
                                                            onclick="return confirm('Are you sure you want to delete this project?')">
                                                            <i class="mdi mdi-delete" style="font-size: 20px;"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                    <!-- Modal Code Remains Same -->

                                    <!-- View Project Modal -->
                                    <div class="modal fade" id="viewTeamModal{{ $project->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="viewTeamModalLabel{{ $project->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="viewTeamModalLabel{{ $project->id }}">
                                                        Teams for {{ $project->name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <ul>
                                                        @forelse($project->users as $user)
                                                            @if ($user->status == 0)
                                                                <li><span class="text-danger">
                                                                        {{ $user->name }}  (Inactive)</span></li>
                                                            @else
                                                                <li>{{ $user->name }}</li>
                                                            @endif

                                                        @empty
                                                            No Employee assigned.
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

                                     <div class="modal fade" id="projectDetailsModal" tabindex="-1" role="dialog"
                                        aria-labelledby="projectDetailsModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="projectDetailsModalLabel">Project Details
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" id="project-details-content">
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
            $('.view-project-details').on('click', function() {
                const projectId = $(this).data('id');

                // Clear previous content
                $('#project-details-content').html('Loading...');

                // AJAX request
                $.ajax({
                    url: "{{ url('admin/project') }}/" + projectId,
                    method: 'GET',
                    success: function(response) {
                        $('#project-details-content').html(response);
                    },
                    error: function() {
                        $('#project-details-content').html(
                            '<p class="text-danger">Failed to load details.</p>');
                    }
                });
            });
        });

    </script>
@endsection
