@extends('layouts.student-app')

@section('title', 'Attendance')

@section('content')

    <div class="breadcrumbs-area">
        <h3>{{ __('text.All Teacher') }}</h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" class="text-color mr-2">
                    {{ __('text.Back') }}</a>|
                <a href="{{ route(current_user()->role.'.home') }}" class="text-color">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.Teachers Attendance') }}</li>
        </ul>
    </div>
    <div class="section-students">
        <div class="card height-auto mt-5 false-height">
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="panel panel-default">
                </div>
                <div class="card">
                    <div class="card-body">
                        @if(count($teachers) > 0)
                            <div class="title mb-5">
                                <div class="float-left">
                                    <a class="button button--save mr-2 float-left"
                                       href="{{ route('teacher.summary') }}">
                                        {{ __('text.View Summary') }}</a>
                                    <a class="button button--save mr-2 float-left"
                                       href={{ route('teacher.attendance') }}>
                                        {{ __('text.Take Attendance') }}
                                    </a>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-data-div table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('text.Code') }}</th>
                                        <th>{{ __('text.Name') }}</th>
                                        <th>{{ __('text.Attendance') }}</th>
                                    </tr>
                                    </thead>
                                    @foreach($teachers as $key=>$teacher)
                                    <tbody>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $teacher->student_code }}</td>
                                        <td>{{ $teacher->name }}</td>
                                        <td>
                                            <a class="btn-link text-teal" role="button" href="{{ route('user.attendance' , $teacher->id)}}">
                                                <b>{{ __('text.View Attendance') }}</b>
                                            </a>
                                        </td>
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                        @else
                            <p class="text-center">{{ __('text.No_related_data_notification') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

