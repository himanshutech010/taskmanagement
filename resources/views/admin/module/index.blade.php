@extends('layout.admin.default')
@section('title', 'Modules')
@section('content')


    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Module</h3>
            @if (in_array(auth()->user()->role, ['Super Admin', 'Manager']))
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


        <div class="row ">
            @foreach ($modules as $module)
                <div class="col-md-3 d-flex align-items-stretch grid-margin">
                    <div class="card card-img-holder text-white card-hover"
                        style="color: black !important;width: 100%; box-shadow: 0px 0px 12px 0px #b7b7b7; background: #a1bd9e;">
                        {{-- <a href="{{ route('admin.module.show', $module->id) }}" class="text-decoration-none card-link"> --}}
                        <a href="#" class="text-decoration-none card-link">
                            <div class="card-body">
                                <h3 class="mb-1"> Project : {{ $module->project->name }}</h3>
                                <h6 class="card-text">Increased by 20%</h6>
                            </div>
                        </a>

                        @if (in_array(auth()->user()->role, ['Super Admin']))
                            <div class="d-flex justify-content-center gap-3">
                                {{-- <a href="{{ route('admin.modules.edit', ['id' => $module->id]) }}"  class="btn btn-inverse-dark btn-icon-text" style="background-color: transparent;"><i class="mdi mdi-account-edit btn-icon-append"></i>Edit</a> --}}
                                <a href="{{ route('admin.modules.edit', ['id' => $module->id]) }}"
                                    class="btn btn-inverse-dark btn-icon-text" style="background-color: transparent;"><i
                                        class="mdi mdi-account-edit btn-icon-append"></i>Edit</a>
                                {{-- <form action="{{ route('admin.modules.destroy', ['id' => $module->id]) }}" method="POST" style="display:inline-block;"> --}}
                                <form action="#" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-inverse-dark"
                                        onclick="return confirm('Are you sure you want to delete this department?')"
                                        style="background-color: transparent;"><i class="mdi mdi-delete"
                                            style="font-size: 20px;"></i></button>
                                </form>

                            </div>
                        @endif
                    </div>
                </div>



                {{-- <div class="card-body">
                            <h4 class="card-title mb-4">{{ $module->name }}</h4>
                            <a href="{{ route('admin.modules.edit',  $module->id) }}" class="btn btn-sm  btn-gradient-success">
                                Edit Module.{{ $module->name }}
                            </a>
                            </div> --}}
            @endforeach
        </div>

        {{-- </div>
                    </div>
                </div>
              </div>
            </div> --}}
    </div>


@endsection
