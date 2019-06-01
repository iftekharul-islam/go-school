@extends('layouts.student-app')

@section('title', 'Course')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>Edit Course Data</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            <h2>Edit Course Data</h2>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="new-added-form" action="{{url('edit/course/'.$course->id)}}" method="post">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('course_name') ? ' has-error' : '' }}">
                    <label for="course_name" class="col-md-4 control-label">Course Name</label>

                    <div class="col-md-8">
                        <input id="course_name" type="text" class="form-control" name="course_name" value="{{ $course->course_name }}" required>

                        @if ($errors->has('course_name'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('course_name') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('course_time') ? ' has-error' : '' }}">
                    <label for="course_time" class="col-md-4 control-label">Course Time</label>

                    <div class="col-md-8">
                        <input id="course_time" type="text" class="form-control" name="course_time" value="{{ $course->course_time }}" required>

                        @if ($errors->has('course_time'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('course_time') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="btn btn-danger btn-lg">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
