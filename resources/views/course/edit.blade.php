@extends('layouts.student-app')

@section('title', 'Course')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            </a>Edit Course
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Edit Course</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-12 col-lg-8 col-xl-8 col-md-10">
            <div class="card">
                <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="new-added-form" action="{{route('course.update', $course->id)}}" method="post">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('course_name') ? ' has-error' : '' }}">
                    <label for="course_name" class="col-md-4 control-label">Course Name</label>

                    <div class="col-md-12">
                        <input id="course_name" type="text" class="form-control" name="course_name" value="{{ $course->course_name }}" required>

                        @if ($errors->has('course_name'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('course_name') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>
                <div class="form-group false-padding-bottom-form">
                    <label class="col-sm-12 control-label false-padding-bottom">Assign Course Teacher</label>
                    <div class="col-sm-12">
                        <select class="form-control" name="teacher_id">
                            <option value="0">N/A</option>
                                @if(count($teachers) > 0)
                                    @foreach($teachers as $teacher)
                                        <option value="{{$teacher->id}}" @if($course->teacher_id == $teacher->id) selected @endif>
                                            {{$teacher->name}} {{$teacher->department_name}}
                                        </option>
                                    @endforeach
                                @endif
                        </select>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('course_time') ? ' has-error' : '' }}">
                    <label class="col-sm-12 control-label false-padding-bottom">Course Time</label>

                    <div class="col-md-12">
                        <input id="course_time" type="text" class="form-control" name="course_time" value="{{ $course->course_time }}">

                        @if ($errors->has('course_time'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('course_time') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-12">
                        <button type="submit" class="button button--save">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        </div>
    </div>
@endsection
