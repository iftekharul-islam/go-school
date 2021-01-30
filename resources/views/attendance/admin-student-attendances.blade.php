@extends('layouts.student-app')

@section('title', 'Attendance')
@section('content')
{{--    <div class="dashboard-content-one">--}}
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>
                {{ __('text.student_attendance') }}
            </h3>
            <ul>
                <li>
                    <a href="{{ URL::previous() }}" style="color: #32998f!important;">Back &nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url( current_user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
                </li>
                <li>{{ __('text.student_attendance') }}</li>
            </ul>
        </div>
        @if(count($attendances) > 0)
            <div class="card height-auto mb-5">
                <div class="card-body">
                    @foreach($attendances as $att)
                        <div class="row">
                            <div class="col-lg-3 col-xs-6 col-sm-6">
                                <h5 class="text-teal"><strong><i class="fas fa-id-card-alt mr-2"></i>{{ __('text.Name') }}: </strong>{{ $att->student->name }}</h5>
                            </div>
                            <div class="col-lg-3 col-xs-6 col-sm-6">
                                <h5 class="text-teal"><strong><i class="fas fa-sliders-h mr-2"></i>{{ __('text.student_id') }}: </strong>{{ $att->student->student_code }}</h5>
                            </div>
                            <div class="col-lg-3 col-xs-6 col-sm-6">
                                <h5 class="text-teal"><strong> <i class="fas fa-building mr-2"></i>{{ __('text.Class') }}: </strong>{{ $att->section->class->class_number }}</h5>
                            </div>
                            <div class="col-lg-3 col-xs-6 col-sm-6">
                                <h5 class="text-teal"><strong><i class="fas fa-sliders-h mr-2"></i>{{ __('text.Section') }}: </strong>{{ $att->section->section_number }}</h5>
                            </div>
                        </div>
                        @break
                    @endforeach
                </div>
            </div>
                @include('layouts.student.attendances-table')

        @else
            <div class="card">
                <div class="card-body false-height">
                    <h4 class="text-center">{{ __('text.No Related Data Found') }}</h4>
                </div>
            </div>
        @endif
        <!-- Student Attendence Area End Here -->
{{--    </div>--}}
@endsection
