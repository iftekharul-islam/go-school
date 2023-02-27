@extends('layouts.student-app')

@section('title', 'Promote Section Students')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.promote_students') }}
        </h3>
        <ul>
            <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }}</a>|
                <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.promote_students') }}</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            @if(count($students) > 0)
                @foreach ($students as $student)
                    <div class="page-panel-title">
                        <b>Section</b> - {{ $student->section->section_number}} &nbsp; <b>Class</b> - {{$student->section->class->class_number}}
                        <span class="float-right"><b>Current Date Time:</b> &nbsp;{{ Carbon\Carbon::now()->format('h:i A d/m/Y')}}</span>
                    </div>
                    @break($loop->first)
                @endforeach
                    <div class="card-body false-height">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @component('components.promote-students',['students'=>$students,'classes'=>$classes,'section_id'=>$section_id])
                        @endcomponent
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
