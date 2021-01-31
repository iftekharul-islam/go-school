@extends('layouts.student-app')

@section('title', 'My Child Details')

@section('content')
    <div class="breadcrumbs-area">
        <ul>
            <h3>{{ __('text.my_child') }}</h3>
            <li>
                <a href="{{ URL::previous() }}" >{{ __('text.Back') }}
                    &nbsp;|</a>
                <a href="{{ (auth()->user()->role. '.home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.my_child') }}</li>
        </ul>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @elseif(session('error-status'))
        <div class="alert alert-success">
            {{ session('error-status') }}
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
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="item-img-round mt-5">
                                @if(!empty($child->pic_path))
                                    <img src="{{ url($child->pic_path)}}" data-src="{{url($child->pic_path) }}"
                                         class="" id="my-profile"
                                         alt="Profile Picture" width="100%">
                                @else
                                    @if(strtolower($child->gender) == 'male')
                                        <img src="{{ asset('template/img/user-default.png') }}"
                                             class="img-thumbnail" width="100%">
                                    @else
                                        <img src="{{ asset('template/img/female-default.png') }}"
                                             width="100%">
                                    @endif
                                @endif
                            </div>
                            <div class="item-content">
                                <div class="profile-name">
                                    <h3 class="mt-3">{{ $child->name }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="heading-sub fancy4 ">{{ __('text.basic_details') }}</div>
                            <div class="item-content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class=" table-responsive border-right">
                                            <table class="text-wrap table-borderless table ">
                                                <tr>
                                                    <td class="text-nowrap font-medium text-dark-medium">{{ __('text.student_code') }}:
                                                    </td>
                                                    <td class="text-capitalize">{{ $child->student_code }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-nowrap font-medium text-dark-medium">{{ __('text.student_id') }}:
                                                    </td>
                                                    <td class="text-capitalize">{{ $child->studentInfo['student_indentification'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-medium text-dark-medium text-nowrap">{{ __('text.version') }}:</td>
                                                    <td class="text-capitalize">{{ $child->studentInfo['version'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-medium text-dark-medium text-nowrap">{{ __('text.gender') }}:</td>
                                                    <td class="text-capitalize">{{ $child->gender }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-medium text-dark-medium text-nowrap">{{ __('text.religion') }}:</td>
                                                    <td class="text-capitalize">{{ $child->studentInfo['religion'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-medium text-dark-medium">{{ __('text.birthday') }} :</td>
                                                    <td class="text-left">
                                                        {{ Carbon\Carbon::parse($child->studentInfo['birthday'])->format('d/m/Y') }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-medium text-dark-medium">{{ __('text.email_username') }}:</td>
                                                    <td class="text-left">{{ $child->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-medium text-dark-medium text-nowrap">{{ __('text.address') }}:</td>
                                                    <td class="text-capitalize">{{ $child->address }}</td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class=" table-responsive">
                                            <table class="text-wrap table-borderless table ">
                                                <tr>
                                                    <td class="font-medium text-dark-medium text-nowrap">{{ __('text.Class') }}:</td>
                                                    <td>{{$child->section['class']['class_number']}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-medium text-dark-medium text-nowrap">{{ __('text.Section') }}:</td>
                                                    <td class="text-capitalize">{{$child->section['section_number']}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-medium text-dark-medium text-nowrap">{{ __('text.roll_number') }}:</td>
                                                    <td class="text-capitalize">{{ $child->studentInfo['roll_number'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-medium text-dark-medium text-nowrap">{{ __('text.Shift') }}:</td>
                                                    <td class="text-capitalize">{{ $child->studentInfo['shift'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-medium text-dark-medium text-nowrap">{{ __('text.session') }}:</td>
                                                    <td class="text-capitalize">{{$child->studentInfo['session']}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-medium text-dark-medium text-nowrap">{{ __('text.group') }}:</td>
                                                    <td class="text-capitalize">{{$child->studentInfo['group']}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-medium text-dark-medium text-nowrap">{{ __('text.nationality') }}:
                                                    </td>
                                                    <td class="text-capitalize">{{$child->nationality}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-medium text-dark-medium text-nowrap">{{ __('text.blood_group') }}:
                                                    </td>
                                                    <td class="text-capitalize">{{$child->blood_group}}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card height-auto false-height">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="course-tab" data-toggle="tab" href="#course" role="tab"
                               aria-controls="course" aria-selected="true">{{ __('text.courses') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="grade-tab" data-toggle="tab" href="#grade" role="tab"
                               aria-controls="grade" aria-selected="false">{{ __('text.Grades') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="fee-summary-tab" data-toggle="tab" href="#fee-summary"
                               role="tab"
                               aria-controls="fee-summary" aria-selected="false">{{ __('text.fees_summary') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="syllabus-tab" data-toggle="tab" href="#syllabus" role="tab"
                               aria-controls="syllabus" aria-selected="false">{{ __('text.Syllabus') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="class-routine-tab" data-toggle="tab" href="#class-routine"
                               role="tab"
                               aria-controls="class-routine"
                               aria-selected="false">{{ __('text.Class Routine') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="attendance-tab" data-toggle="tab" href="#attendance" role="tab"
                               aria-controls="attendance" aria-selected="false">{{ __('text.Attendance') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="message-tab" data-toggle="tab" href="#message" role="tab"
                               aria-controls="message" aria-selected="false">{{ __('text.message') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-5" id="myTabContent">

                        <div class="tab-pane fade show active" id="course" role="tabpanel"
                             aria-labelledby="course-tab">
                            <div class="heading-layout1">
                                <div class="item-title mt-5">
                                    <h3>{{ __('text.my_course') }}</h3>
                                </div>
                            </div>
                            @if(count($courses) > 0)
                                <div class="table-responsive">
                                    @component('components.student_course_table',['courses'=>$courses])
                                    @endcomponent
                                </div>
                            @else
                                <div class="card mt-5 false-height">
                                    <div class="card-body">
                                        <div class="card-body-body mt-5 text-center">
                                            {{ __('text.No Related Data Found') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="tab-pane fade" id="grade" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="heading-layout1">
                                <div class="item-title mt-5">
                                    <h3>{{ __('text.my_grade') }}</h3>
                                </div>
                            </div>
                            @if(count($grades) > 0)
                                <div class="panel-body">
                                    @include('layouts.student.grade-table')
                                </div>
                            @else
                                <div class="mt-5 false-height">
                                    <div class="card-body mt-5 text-center">
                                        {{ __('text.No Related Data Found') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="fee-summary" role="tabpanel" aria-labelledby="contact-tab">
                            <div class="heading-layout1">
                                <div class="item-title mt-5">
                                    <h3>{{ __('text.payment_summary') }}</h3>
                                </div>
                            </div>
                            <div class="table-responsive">
                                @component('components.fee_summary', [  'student' => $student,
                                                                    'discounts' => $discounts,
                                                                    'totalAmount' => $totalAmount,
                                                                    'totalFine' => $totalFine,
                                                                    'totalDiscount' => $totalDiscount,
                                                                    'totalFeePaid' => $totalFeePaid,
                                                                    'totalPaid' => $totalPaid,
                                                                    'paidAmount' => $paidAmount,
                                                                ]))
                                @endcomponent
                            </div>

                        </div>
                        <div class="tab-pane fade" id="syllabus" role="tabpanel" aria-labelledby="syllabus-tab">
                            <div class="heading-layout1">
                                <div class="item-title mt-5">
                                    <h3>{{ __('text.my_syllabus') }}</h3>
                                </div>
                            </div>
                            @component('components.syllabus', [ 'syllabuses' => $syllabuses ])
                            @endcomponent
                        </div>
                        <div class="tab-pane fade" id="class-routine" role="tabpanel"
                             aria-labelledby="class-routine-tab">
                            @component('components.uploaded-files-list',['files'=>$files,'parent'=>($section_id !== 0)?'section':'','upload_type'=>'routine'])
                            @endcomponent
                        </div>
                        <div class="tab-pane fade show" id="attendance" role="tabpanel"
                             aria-labelledby="attendance-tab">
                            <div class="my-5">
                                @if(count($attendances) > 0)
                                    @include('layouts.student.attendances_table')
                                @else
                                    <h4 class="text-center">{{ __('text.No Related Data Found') }}</h4>
                                @endif
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="message" role="tabpanel" aria-labelledby="message-tab">

                            @component('components.message', ['messages' => $messages])
                            @endcomponent

                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection
