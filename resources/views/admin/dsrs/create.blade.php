@extends('layout.admin.default')
@section('title', 'Create DSR')
@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Create DSR </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dsr.index') }}" class="btn btn-block btn-lg btn-gradient-success">Back</a>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">DSR Form</h4>
                        <form class="forms-sample" method="post" action="{{ route('admin.dsr.store') }}">
                            @csrf
                            <div class="row mb-4">
                                <!-- Today Work -->
                                <div class="form-group col-md-6">
                                    <label for="today_work">Today Work<span class="text-danger">*</span></label>
                                    <input id="today_work" class="form-control" type="text" name="today_work"
                                        value="{{ old('today_work') }}" placeholder="Enter today's work" required>
                                    @if ($errors->has('today_work'))
                                        <span class="error-message">{{ $errors->first('today_work') }}</span>
                                    @endif
                                </div>

                                <!-- Comment -->
                                <div class="form-group col-md-6">
                                    <label for="comment">Comment</label>
                                    <input id="comment" class="form-control" type="text" name="comment"
                                        value="{{ old('comment') }}" placeholder="Enter a comment">
                                    @if ($errors->has('comment'))
                                        <span class="error-message">{{ $errors->first('comment') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-4">
                                <!-- Status -->
                                <div class="form-group col-md-6">
                                    <label for="status">Status<span class="text-danger">*</span></label>
                                    <select id="status" name="status" class="form-control form-control-sm" required>
                                        <option value="" disabled selected>Choose...</option>
                                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>
                                            In Progress</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                            Completed</option>
                                        <option value="not_started" {{ old('status') == 'not_started' ? 'selected' : '' }}>
                                            Not Started</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="error-message">{{ $errors->first('status') }}</span>
                                    @endif
                                </div>

                                <!-- Time Taken -->
                                <div class="form-group col-md-6">
                                    <label for="time_taken">Time Taken</label>
                                    <input id="time_taken" class="form-control" type="time" name="time_taken"
                                        value="{{ old('time_taken') }}">
                                    @if ($errors->has('time_taken'))
                                        <span class="error-message">{{ $errors->first('time_taken') }}</span>
                                    @endif
                                </div>
                            </div>

                            <button type="submit" class="btn btn-gradient-success me-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
