@extends('layout.admin.default')
@section('title', 'DSR Index')
@section('content')

    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Daily Status Report (DSR) </h3>

            @if (in_array(auth()->user()->role, ['Super Admin', 'Admin']))
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dsr.create') }}" class="btn btn-block btn-lg btn-gradient-success">+
                                Add DSR</a>
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
                                    <th>DSR ID</th>
                                    <th>Employee</th>
                                    <th>Date</th>
                                    <th>Today Work</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                    <th>Time Taken</th>
                                    @if (in_array(auth()->user()->role, ['Super Admin', 'Admin']))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dsrs as $dsr)
                                    <tr>
                                        <td><a href="#" class="view-dsr-details" data-id="{{ $dsr->id }}"
                                                data-toggle="modal" data-target="#dsrDetailsModal"
                                                style="color:green;text-decoration: none;">
                                                {{ $dsr->id }}
                                            </a></td>
                                        <td>{{ $dsr->employee->name }}</td>
                                        <td>{{ $dsr->date }}</td>
                                        <td>{{ $dsr->today_work }}</td>
                                        <td>{{ $dsr->comment }}</td>
                                        <td>
                                            <span
                                                class="badge badge-rounded {{ $dsr->status == 'completed' ? 'badge-success' : 'badge-warning' }}"
                                                style="border-radius: 20px;">
                                                {{ ucfirst($dsr->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $dsr->time_taken }}</td>
                                        @if (in_array(auth()->user()->role, ['Super Admin', 'Admin']))
                                            <td>
                                                <button type="button" class="btn btn-inverse-dark btn-icon">
                                                    <a href="{{ route('admin.dsr.edit', $dsr->id) }}"><i
                                                            class="mdi mdi-account-edit btn-icon-append"
                                                            style="color:black;font-size:20px;"></i></a>
                                                </button>

                                                <form action="{{ route('admin.dsr.destroy', $dsr->id) }}" method="POST"
                                                    style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-inverse-dark btn-icon"
                                                        onclick="return confirm('Are you sure you want to delete this DSR?')"><i
                                                            class="mdi mdi-delete" style="font-size: 20px;"></i></button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>

                                    <!-- DSR Details Modal -->
                                    <div class="modal fade" id="dsrDetailsModal" tabindex="-1" role="dialog"
                                        aria-labelledby="dsrDetailsModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="dsrDetailsModalLabel">DSR Details</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" id="dsr-details-content">
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
            $('.view-dsr-details').on('click', function() {
                const dsrId = $(this).data('id');

                // Clear previous content
                $('#dsr-details-content').html('Loading...');

                // AJAX request
                $.ajax({
                    url: "{{ url('admin/dsr') }}/" + dsrId,
                    method: 'GET',
                    success: function(response) {
                        $('#dsr-details-content').html(response);
                    },
                    error: function() {
                        $('#dsr-details-content').html(
                            '<p class="text-danger">Failed to load details.</p>');
                    }
                });
            });
        });
    </script>
@endsection
