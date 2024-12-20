<!-- Add in the <head> -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Add before the closing </body> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@extends('layout.admin.default')
@section('title', 'Clients')
@section('content')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Client Data </h3>

        @if (in_array(auth()->user()->role, ['Super Admin','Manager']))
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.clients.create') }}" class="btn btn-block btn-lg btn-gradient-success">+ Add Client</a>
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
                                <th>Client Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Linked In</th>
                                <th>Skype</th>
                                <th>Action</th>
                            
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td><a href="#" class="view-client-details" data-id="{{ $client->id }}"
                                                data-toggle="modal" data-target="#clientDetailsModal"
                                                style="color:green;text-decoration: none;font-weight: bold;">
                                                {{ $client->client_name }}
                                            </a></td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->mobile }}</td>
                                    <td>
                                        @if($client->linkedin)
                                            <a href="{{ $client->linkedin }}" target="_blank" >
                                            <i class="mdi  mdi-linkedin-box" style="font-size: 25px;"></i> 
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                    <td> @if($client->skype)
                                            <a href="{{ $client->skype }}" target="_blank" >
                                            <i class="mdi mdi-skype-business" style="font-size: 25px;"></i> 
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    @if (in_array(auth()->user()->role, ['Super Admin','Manager']))
                                    <td>
                                    <button type="button" class="btn btn-inverse-dark btn-icon">
                                                    <a href="{{ route('admin.clients.edit', $client->id) }}"><i
                                                            class="mdi mdi-account-edit btn-icon-append"
                                                            style="color:black;font-size:20px;"></i></a>
                                                </button>
                                    
                                        @if (in_array(auth()->user()->role, ['Super Admin']))
                                        <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-inverse-dark btn-icon" onclick="return confirm('Are you sure you want to delete this client?')">
                                                <i class="mdi mdi-delete" style="font-size: 20px;"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                    @endif
                                </tr>
                                 <!-- Client Details Modal -->
                                    <div class="modal fade" id="clientDetailsModal" tabindex="-1" role="dialog"
                                        aria-labelledby="clientDetailsModalLabel" aria-hidden="true">
                                        <div class="modal-dialog " role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="clientDetailsModalLabel">Client Details
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" id="client-details-content">
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
            $('.view-client-details').on('click', function() {
                const clientId = $(this).data('id');

                // Clear previous content
                $('#client-details-content').html('Loading...');

                // AJAX request
                $.ajax({
                    url: "{{ url('admin/client') }}/" + clientId,
                    method: 'GET',
                    success: function(response) {
                        $('#client-details-content').html(response);
                    },
                    error: function() {
                        $('#client-details-content').html(
                            '<p class="text-danger">Failed to load details.</p>');
                    }
                });
            });
        });

    </script>

@endsection
