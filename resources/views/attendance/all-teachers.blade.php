@extends('layouts.student-app')

@section('title', 'Attendance')

@section('content')

    <div class="breadcrumbs-area">
        <h3>{{ __('text.All Teacher') }}</h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.Teachers Attendance') }}</li>
        </ul>
    </div>
    <div class="section-students">
        <div class="card height-auto mt-5 false-height">
            <div class="card-body">
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
{{--                    @if(count($users) > 0)--}}
                </div>
                    <div class="card">
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>

                        @elseif (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="title mb-5" style="overflow: hidden" >
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
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Attendance</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($teachers as $key=>$teacher)
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $teacher->student_code }}</td>
                                        <td>{{ $teacher->name }}</td>
                                        <td>
                                            <a class="btn-link text-teal" role="button" href="{{ route('staff.attendance', $teacher->id)}}">
                                                <b>{{ __('text.View Attendance') }}</b>
                                            </a>
                                        </td>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
{{--            @else--}}
{{--                <div class="card mt-5 false-height">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="card-body-body mt-5 text-center">--}}
{{--                            {{ __('text.No Related Data Found') }}--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
        </div>
    </div>
@endsection

