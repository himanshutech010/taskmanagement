@extends('layout.admin.default')
@section('title', 'Clients')
@section('content')

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Client Data </h3>

        @if (in_array(auth()->user()->role, ['Super Admin']))
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
                    <h4 class="card-title">Client Table</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Client Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Linked IN</th>
                                <th>Skype</th>
                                <th>Other</th>
                                @if (in_array(auth()->user()->role, ['Super Admin']))
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td>{{ $client->client_name }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->mobile }}</td>
                                    <td>
                                        @if($client->linkedin)
                                            <a href="{{ $client->linkedin }}" target="_blank" >
                                                {{ $client->linkedin }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    
                                    {{-- <td> <a href="{{ $client->linkedin}}"></a></td> --}}
                                    <td>{{$client->skype}}</td>
                                    <td>{{$client->other}}</td>
                                    @if (in_array(auth()->user()->role, ['Super Admin']))
                                    <td>
                                        <a href="{{ route('admin.clients.edit', $client->id) }}" class="btn btn-inverse-dark">
                                            <i class="mdi mdi-account-edit btn-icon-append"></i>Edit
                                        </a>
                                        <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-inverse-dark btn-icon" onclick="return confirm('Are you sure you want to delete this client?')">
                                                <i class="mdi mdi-delete" style="font-size: 20px;"></i>
                                            </button>
                                        </form>
                                    </td>
                                    @endif
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
