


@extends('layout.admin.default')
@section('title', 'Departments')
@section('content')

<style>
/* Card Styling */
.card-link {
    text-decoration: none;
    color: inherit; /* Maintain the color styling */
    position: relative;
}

.card-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden; /* Ensures hover effects are contained within the card */
}

.card-hover:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

/* Hover Actions Styling */
.card-hover .hover-actions {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.card-hover:hover .hover-actions {
    opacity: 1;
}

.hover-actions button,
.hover-actions a {
    margin: 0 5px;
    color: white !important;
    text-decoration: none;
}
</style>

<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">Departments Data</h3>
        @if (in_array(auth()->user()->role, ['Super Admin']))
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.department.create') }}" class="btn btn-block btn-lg btn-gradient-success">
                        + Add Department
                    </a>
                </li>
            </ol>
        </nav>
        @endif
    </div>

    {{-- <div class="row d-flex "> --}}
        <div class="row d-flex justify-content-center">
        @foreach($departments as $dept)
        <div class="col-md-3 d-flex align-items-stretch grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white card-hover">
                <a href="{{ route('admin.department.show', $dept->id) }}" class="text-decoration-none card-link">
                    <div class="card-body">
                        <img src="{{ asset('public/admin/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                        <h4 class="font-weight-normal ">{{ $dept->name }} <i class="mdi mdi-diamond mdi-24px float-right"></i></h4>
                        <h2 class="mb-1">80 / 100</h2>
                        <h6 class="card-text">Increased by 20%</h6>
                    </div>
                </a>

                @if (in_array(auth()->user()->role, ['Super Admin']))
                <div class="d-flex justify-content-center gap-3">
                      <a href="{{ route('admin.department.edit', ['id' => $dept->id]) }}"  class="btn btn-inverse-dark btn-icon-text" style="background-color: transparent;"><i class="mdi mdi-account-edit btn-icon-append"></i>Edit</a>
<form action="{{ route('admin.department.destroy', ['id' => $dept->id]) }}" method="POST" style="display:inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-inverse-dark" onclick="return confirm('Are you sure you want to delete this department?')" style="background-color: transparent;"><i class="mdi mdi-delete" style="font-size: 20px;"></i></button>
</form>

                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection


   
   
    

