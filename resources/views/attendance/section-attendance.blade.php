@extends('layouts.student-app')

@section('title', 'Attendance')

@section('content')

    <div class="breadcrumbs-area">
        <h3>{{ __('text.All Students') }}</h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.Students Attendance') }}</li>
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
                    @if(count($users) > 0)

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
                                   href={{ route('attendance.summary', $students[0]->section->id) }}>
                                    {{ __('text.View Summary') }}</a>
                                <a class="button button--save mr-2 float-left"
                                   href={{ route('student.attendance', $students[0]->section->id) }}>
                                    {{ __('text.Take Attendance') }}</a>
                                <a class="button button--save float-left"
                                   href={{ route('export.AbsentStudent',
                                   ['class_number'=>$class->class_number,
                                    'section_name'=>$students[0]->section->section_number,
                                     'section_id'=>$students[0]->section->id ]) }}>
                                    {{ __('text.Export Absent Students') }}</a>
                            </div>
                        </div>
                        @component('components.users',['users'=>$users,'current_page'=>$current_page,'per_page'=>$per_page])
                        @endcomponent
                    </div>
                </div>

            </div>
                @else
                <div class="card mt-5 false-height">
                    <div class="card-body">
                        <div class="card-body-body mt-5 text-center">
                            {{ __('text.No_related_data_notification') }}
                        </div>
                    </div>
                </div>
                @endif
        </div>
    </div>
@endsection

