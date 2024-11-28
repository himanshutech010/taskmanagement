

{{-- 
///////////////////

.card-hover {
    position: relative;
    overflow: hidden;
}

.hover-actions {
    display: none;
    background: rgba(0, 0, 0, 0.6); /* Semi-transparent background */
    top: 0;
    left: 0;
    z-index: 10;
}

.card-hover:hover .hover-actions {
    display: flex;
}
{{--  

<div class="row d-flex justify-content-center">
    @foreach($departments as $dept)
    <div class="col-md-4 d-flex align-items-stretch grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white card-hover position-relative">
            <a href="{{ route('admin.department.show', $dept->id) }}" class="text-decoration-none card-link">
                <div class="card-body">
                    <img src="{{ asset('public/admin/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">{{ $dept->name }} 
                        <i class="mdi mdi-diamond mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">80 / 100</h2>
                    <h6 class="card-text">Increased by 20%</h6>
                </div>
            </a>

            <!-- Hover Buttons -->
            <div class="hover-actions position-absolute w-100 h-100 d-flex justify-content-center align-items-center">
                <a href="{{ route('admin.department.edit', $dept->id) }}" class="btn btn-warning btn-sm mx-1">Edit</a>
                <form action="{{ route('admin.department.destroy', $dept->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm mx-1" onclick="return confirm('Are you sure you want to delete this department?')">Remove</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

///////////////
--}}
{{--  --}}
 
<!-- Add in the <head> -->
    {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add before the closing </body> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
    


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
        @if (in_array(auth()->user()->role, ['Super Admin', 'Manager']))
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.department.create') }}" class="btn btn-block btn-lg btn-gradient-primary">
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

                <!-- Hover Actions for Edit & Delete     ['id' => $item->id] -->
                <div class="d-flex justify-content-center gap-3">
                    {{-- <a href="{{ route('admin.department.edit', ['id' => $dept->id]) }}" class="text-warning"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="fa-solid fa-pen-to-square text-warning"></i></a> --}}
                    {{-- <a href="{{ route('admin.department.edit', ['id' => $dept->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                   <form action="{{ route('admin.department.destroy', ['id' => $dept->id]) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this department?')">Delete</button>
                    </form> --}}
                
                      <a href="{{ route('admin.department.edit', ['id' => $dept->id]) }}" class="btn btn-info btn-fw">Edit</a>
<form action="{{ route('admin.department.destroy', ['id' => $dept->id]) }}" method="POST" style="display:inline-block;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-fw " onclick="return confirm('Are you sure you want to delete this department?')">Delete</button>
</form>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection


   
   
    

