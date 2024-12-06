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

    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
                <div class="card card-hover" style="background: #b5c7b1;box-shadow: 0px 0px 12px 0px #b7b7b7;">
                  <div class="card-body">
                    <h4 class="card-title"></h4>
                    <div>
                        @foreach ( $modules as $module)
                        <div class="card-body">
                            <h4 class="card-title mb-4">{{ $module->name }}</h4>
                            <a href="{{ route('admin.modules.edit',  $module->id) }}" class="btn btn-sm  btn-gradient-success">
                                Edit Module.{{ $module->name }}
                            </a>
                            </div>
                        @endforeach
                      
                    </div>
                    </div>
                </div>
              </div>
            </div>
    </div>
</div>

@endsection