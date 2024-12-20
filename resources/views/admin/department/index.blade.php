@extends('layout.admin.default')
@section('title', 'Departments')
@section('content')



    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Departments Data</h3>
            @if (in_array(auth()->user()->role, ['Super Admin']))
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.department.create') }}"
                                class="btn btn-block btn-lg btn-gradient-success">
                                + Add Department
                            </a>
                        </li>
                    </ol>
                </nav>
            @endif
        </div>

        {{-- <div class="row d-flex "> --}}
        <div class="row ">
            @foreach ($departments as $dept)
                <div class="col-md-3 d-flex align-items-stretch grid-margin">
                    <div class="card card-img-holder text-white card-hover"
                        style="color: black !important;width: 100%; box-shadow: 0px 0px 12px 0px #b7b7b7; background: #a1bd9e;">
                        <a href="{{ route('admin.department.show', $dept->id) }}" class="text-decoration-none card-link">
                            <div class="card-body">
                                <img src="{{ asset('public/admin/images/dashboard/circle.svg') }}" class="card-img-absolute"
                                    alt="circle-image" />
                                <h4 class="font-weight-normal ">{{ $dept->name }} <i
                                        class="mdi mdi-diamond mdi-24px float-right"></i></h4>
                                <h2 class="mb-1">80 / 100</h2>
                                <h6 class="card-text">Increased by 20%</h6>
                            </div>
                        </a>

                        @if (in_array(auth()->user()->role, ['Super Admin']))
                            <div class="d-flex justify-content-center gap-3">
                                <a href="{{ route('admin.department.edit', ['id' => $dept->id]) }}"
                                    class="btn btn-inverse-dark btn-icon-text" style="background-color: transparent;"><i
                                        class="mdi mdi-account-edit btn-icon-append" style="font-size:20px;color:black;"></i></a>
                                <form action="{{ route('admin.department.destroy', ['id' => $dept->id]) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-inverse-dark"
                                        onclick="return confirm('Are you sure you want to delete this department?')"
                                        style="background-color: transparent;"><i class="mdi mdi-delete"
                                            style="font-size: 20px;color:black;"></i></button>
                                </form>

                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>

@endsection
