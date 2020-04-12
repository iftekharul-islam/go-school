@extends('layouts.student-app')
@section('title', 'Exam Details')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.exam_details') }}
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li> <a style="margin-left: 8px;" href="{{ url('/exams/active') }}">{{ __('text.Active Exams') }}</a></li>
            <li>{{ __('text.exam_details') }}</li>
        </ul>
    </div>

    <div class="card false-height">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>{{ __('text.Class') }}</th>
                    <th>{{ __('text.course_name') }}</th>
                    <th>{{ __('text.course_type') }}</th>
                    <th>{{ __('text.course_time') }}</th>
                    <th>{{ __('text.course_teacher') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($courses as $course)
                    @if ( $exam_id == $course->exam_id )
                        <tr>
                            <td>{{ $course->class->class_number }}</td>
                            <td>{{ $course->course_name }}</td>
                            <td>{{ $course->course_type }}</td>
                            <td>{{ $course->course_time }}</td>
                            <td>
                                @if ( isset($course->teacher['student_code']) )
                                    <a href="{{url('user/'.$course->teacher['student_code'])}}">{{ $course->teacher->name }}</a>
                                @else
                                    {{ $course->teacher['name'] }}
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
