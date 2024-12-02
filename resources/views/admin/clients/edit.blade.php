@extends('layout.admin.default')
@section('title', 'Update Client')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title"> Update Client </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.clients.index') }}" class="btn btn-block btn-lg btn-gradient-success">Back</a>
                </li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Client Form</h4>
                    <form class="forms-sample" method="POST" action="{{ route('admin.clients.update', $client->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-4">
                            <!-- Client Name -->
                            <div class="form-group col-md-6">
                                <label for="client_name">Client Name<span class="text-danger">*</span></label>
                                <input id="client_name" class="form-control" type="text" name="client_name" value="{{ old('client_name', $client->client_name) }}" placeholder="Enter Client Name">
                                @if($errors->has('client_name'))
                                    <span class="error-message">{{ $errors->first('client_name') }}</span>
                                @endif
                            </div>

                            <!-- Mobile -->
                            <div class="form-group col-md-6">
                                <label for="mobile">Mobile</label>
                                <input id="mobile" class="form-control" type="text" name="mobile" value="{{ old('mobile', $client->mobile) }}" placeholder="Enter Mobile Number">
                                @if($errors->has('mobile'))
                                    <span class="error-message">{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-4">
                            <!-- Email -->
                            <div class="form-group col-md-6">
                                <label for="email">Email<span class="text-danger">*</span></label>
                                <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $client->email) }}" placeholder="Enter Email">
                                @if($errors->has('email'))
                                    <span class="error-message">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <!-- LinkedIn -->
                            <div class="form-group col-md-6">
                                <label for="linkedin">LinkedIn</label>
                                <input id="linkedin" class="form-control" type="url" name="linkedin" value="{{ old('linkedin', $client->linkedin) }}" placeholder="Enter LinkedIn Profile URL">
                                @if($errors->has('linkedin'))
                                    <span class="error-message">{{ $errors->first('linkedin') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-4">
                            <!-- Skype -->
                            <div class="form-group col-md-6">
                                <label for="skype">Skype</label>
                                <input id="skype" class="form-control" type="text" name="skype" value="{{ old('skype', $client->skype) }}" placeholder="Enter Skype ID">
                                @if($errors->has('skype'))
                                    <span class="error-message">{{ $errors->first('skype') }}</span>
                                @endif
                            </div>

                            <!-- Other Contact -->
                            <div class="form-group col-md-6">
                                <label for="other">Other</label>
                                <input id="other" class="form-control" type="text" name="other" value="{{ old('other', $client->other) }}" placeholder="Enter Other Contact">
                                @if($errors->has('other'))
                                    <span class="error-message">{{ $errors->first('other') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-4">
                            <!-- Location -->
                            <div class="form-group col-md-6">
                                <label for="location">Location</label>
                                <textarea id="location" class="form-control" name="location" rows="3" placeholder="Enter Location">{{ old('location', $client->location) }}</textarea>
                                @if($errors->has('location'))
                                    <span class="error-message">{{ $errors->first('location') }}</span>
                                @endif
                            </div>

                           
                        </div>

                        <button type="submit" class="btn btn-gradient-success me-2">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
