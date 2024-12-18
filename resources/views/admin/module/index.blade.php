<!-- Add in the <head> -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Add before the closing </body> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



@extends('layout.admin.default')
@section('title', 'Modules')
@section('content')


<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Module</h3>
        @if (in_array(auth()->user()->role, ['Super Admin','Manager']))
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.modules.create') }}" class="btn btn-block btn-lg btn-gradient-success">
                        + Add Module
                    </a>
                </li>
            </ol>
        </nav>
        @endif
    </div>

    {{-- <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
                <div class="card card-hover" style="background: #b5c7b1;box-shadow: 0px 0px 12px 0px #b7b7b7;">
                  <div class="card-body">
                    <h4 class="card-title"></h4>
                    <div> --}}
                  <div class="row d-flex justify-content-center">
    @foreach ($modules as $module)
        <div class="col-md-3 d-flex align-items-stretch grid-margin">
            <div class="card card-img-holder text-white card-hover" 
                 style="color: black !important;width: 100%; box-shadow: 0px 0px 12px 0px #b7b7b7; background: #a1bd9e;">
                 
                <a href="#" class="text-decoration-none card-link">
                    <div class="card-body">
                        <img src="{{ asset('public/admin/images/dashboard/circle.svg') }}" 
                             class="card-img-absolute" alt="circle-image" />
                             
                        <h4 class="font-weight-normal">{{ $module->name }} 
                            <i class="mdi mdi-diamond mdi-24px float-right"></i>
                        </h4>
                        <h2 class="mb-1">Project: {{ $module->project->name }}</h2>

                        @php
                            // Get assigned employees for this module
                            $assignedEmployees = $module->details->pluck('assignProject.employee')->flatten();
                        @endphp

                        @if ($assignedEmployees->isEmpty())
                            <p>No employees assigned to this module.</p>
                        @else
                            <h5>Assigned Employees:</h5>
                            <ul>
                                @foreach ($assignedEmployees as $employee)
                                    <li>{{ $employee->name }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <h6 class="card-text">Increased by 20%</h6>
                    </div>
                </a>

                @if (in_array(auth()->user()->role, ['Super Admin']))
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('admin.modules.edit', ['id' => $module->id]) }}"  
                           class="btn btn-inverse-dark btn-icon-text" 
                           style="background-color: transparent;">
                            <i class="mdi mdi-account-edit btn-icon-append"></i>Edit
                        </a>
                        
                        <form action="#" 
                              method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-inverse-dark" 
                                    onclick="return confirm('Are you sure you want to delete this module?')" 
                                    style="background-color: transparent;">
                                <i class="mdi mdi-delete" style="font-size: 20px;"></i>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>

                      
             
    </div>


@endsection