@extends('layouts.student-app')

@section('content')
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('home') }}">Home</a>
            </li>
            <li>Student</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <div class="row">
        <!-- Student Info Area Start Here -->
        <div class="col-4-xxxl col-12">
            <div class="card dashboard-card-ten">
                <div class="card-body">
                    <div class="heading-layout1 mb-5">
                        <div class="item-title">
                            <h3 class="float-left">About Me</h3>
{{--                            <a class="btn btn-lg btn-info float-right" role="button" href="{{url('attendances/0/'.$student->id.'/0')}}">View Attendance</a>--}}
                        </div>
                    </div>
{{--                    @if(!empty($student_info))--}}
                        <div class="student-info">
                            <div class="media media-none--xs">
                                <div class="item-img mt-5">
                                    <img src="{{url($student->pic_path)}}" class="media-img-auto" alt="student">
                                </div>
                                <div class="media-body mt-5">
                                    <h3 class="item-title">{{ Auth::user()->name }}</h3>
                                    <p>{{ $student->about }}</p>
                                </div>
                            </div>
                            <div class="table-responsive info-table">
                                <table class="table text-nowrap">
                                    <tbody>
                                    <tr>
                                        <td>Name:</td>
                                        <td class="font-medium text-dark-medium">{{ Auth::user()->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Gender:</td>
                                        <td class="font-medium text-dark-medium">{{ ucfirst($student->gender) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Blood Group:</td>
                                        <td class="font-medium text-dark-medium">{{ ucfirst($student->blood_group) }}</td>
                                    </tr>
                                    <tr>
                                        @if(isset($student_info->father_name))
                                            <td>Father's Name:</td>
                                            <td class="font-medium text-dark-medium">{{ $student_info->father_name }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        @if(isset($student_info->father_occupation))
                                            <td>Father's Occupation:</td>
                                            <td class="font-medium text-dark-medium">{{ $student_info->father_occupation }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        @if(isset($student_info->mother_name))
                                            <td>Mother's Name:</td>
                                            <td class="font-medium text-dark-medium">{{ $student_info->mother_name }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        @if(isset($student_info->mother_occupation))
                                            <td>Mother's Occupation:</td>
                                            <td class="font-medium text-dark-medium">{{ $student_info->mother_occupation }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        @if(isset($student_info->birthday))
                                            <td>Date of Birth:</td>
                                            <td class="font-medium text-dark-medium">{{ date('d-m-Y', strtotime($student_info->birthday)) }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        @if(isset($student_info->religion))
                                            <td>Religion:</td>
                                            <td class="font-medium text-dark-medium">{{ ucfirst($student_info->religion) }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>E-Mail:</td>
                                        <td class="font-medium text-dark-medium">{{ $student->email }}</td>
                                    </tr>
                                    <tr>
                                        @if(isset($student_info->religion))
                                            <td>Admission Date:</td>
                                            <td class="font-medium text-dark-medium">{{ $student_info->religion }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        @if(isset($student_info->group))
                                            <td>Group:</td>
                                            <td class="font-medium text-dark-medium">{{ ucfirst($student_info->group) }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Section:</td>
                                        <td class="font-medium text-dark-medium">{{ $student->section_id }}</td>
                                    </tr>
                                    <tr>
                                        @if(isset($student_info->student_id))
                                            <td>Roll:</td>
                                            <td class="font-medium text-dark-medium">{{ $student_info->student_id }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>Address:</td>
                                        <td class="font-medium text-dark-medium">{{ $student->address }}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone:</td>
                                        <td class="font-medium text-dark-medium">{{ $student->phone_number }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
{{--                    @endif--}}
                </div>
            </div>
        </div>
        <!-- Student Info Area End Here -->
        <div class="col-8-xxxl col-12">
            <div class="row">
                <!-- Summery Area Start Here -->
                <div class="col-lg-4">
                    <div class="dashboard-summery-one">
                        <div class="row">
                            <div class="col-6">
                                <div class="item-icon bg-light-magenta">
                                    <i class="flaticon-shopping-list text-magenta"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">Notices</div>
                                    <div class="item-number"><span class="counter" data-num="{{ $notices->count() }}">{{ $notices->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="dashboard-summery-one">
                        <div class="row">
                            <div class="col-6">
                                <div class="item-icon bg-light-blue">
                                    <i class="flaticon-calendar text-blue"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">Events</div>
                                    <div class="item-number"><span class="counter" data-num="{{ $events->count() }}">{{ $events->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="dashboard-summery-one">
                        <div class="row">
                            <div class="col-6">
                                <div class="item-icon bg-light-yellow">
                                    <i class="flaticon-percentage-discount text-orange"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">Attendance</div>
                                    @if(!empty($present))
                                        <div class="item-number"><span class="counter" data-num="{{ $present }}">94</span><span>%</span></div>
                                    @else
                                        No Record
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Summery Area End Here -->
                <!-- Exam Result Area Start Here -->
                <div class="col-lg-12">
                    <div class="card dashboard-card-eleven">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>All Exam Schedule</h3>
                                </div>
                            </div>
                            <div class="table-box-wrap">
                                <div class="table-responsive result-table-box">
                                    <table class="table display text-nowrap">
                                        <thead>
                                        <tr>
                                            <th>Exam Name</th>
                                            <th>Term</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Result Published</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($exams as $key => $exam)
                                            <tr>
                                                <td>{{ $exam->exam_name }}</td>
                                                <td>{{ $exam->term }}</td>
                                                <td>{{ date('d-m-Y', strtotime($exam->start_date)) }}</td>
                                                <td>{{ date('d-m-Y',strtotime($exam->end_date)) }}</td>
                                                <td>{{($exam->result_published === 1)?'Yes':'No'}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Exam Result Area End Here -->
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4-xxxl col-xl-6 col-12">
            <div class="card dashboard-card-three">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Attendance</h3>
                        </div>
                    </div>
                    @if(!empty($present))
                        <div class="doughnut-chart-wrap">
                            <canvas id="student-doughnut-chart1" width="100" height="270"></canvas>
                        </div>
                        <div class="student-report">
                            <div class="student-count pseudo-bg-blue">
                                <h4 class="item-title">Absent</h4>
                                <div class="item-number">{{ $absent }}%</div>
                            </div>
                            <div class="student-count pseudo-bg-yellow">
                                <h4 class="item-title">Present</h4>
                                <div class="item-number">{{ $present }}%</div>
                            </div>
                        </div>
                    @else
                        <div style="text-align: center">
                            No Attendance record found
                        </div>
                    @endif
                </div>
            </div>
        </div>
{{--        <div class="col-4-xxxl col-xl-6 col-12">--}}
{{--            <div class="card dashboard-card-thirteen">--}}
{{--                <div class="card-body">--}}
{{--                    <div class="heading-layout1">--}}
{{--                        <div class="item-title">--}}
{{--                            <h3>Event Calender</h3>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="notice-box-wrap">--}}
{{--                        @foreach($events as $event)--}}
{{--                            <div class="notice-list">--}}
{{--                                <div class="post-date bg-skyblue">{{ date('d-m-Y', strtotime($event->created_at)) }}</div>--}}
{{--                                <h6 class="notice-title"><a href="{{ url($event->file_path) }}">{{ $event->title }}</a></h6>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                    <div class="calender-wrap">--}}
{{--                        <div id="fc-calender" class="fc-calender"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <div class="col-4-xxxl col-12">
            <div class="card dashboard-card-six">
                <div class="card-body">
                    <div class="heading-layout1 mg-b-17">
                        <div class="item-title">
                            <h3>Events</h3>
                        </div>
                    </div>
                    <div class="notice-box-wrap">
                        @foreach($events as $event)
                            <div class="notice-list">
                                <div class="post-date bg-skyblue">{{ date('d-m-Y', strtotime($event->created_at)) }}</div>
                                <h6 class="notice-title"><a href="{{ url($event->file_path) }}">{{ $event->title }}</a></h6>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


        <div class="col-4-xxxl col-12">
            <div class="card dashboard-card-six">
                <div class="card-body">
                    <div class="heading-layout1 mg-b-17">
                        <div class="item-title">
                            <h3>Notices</h3>
                        </div>
                    </div>
                    <div class="notice-box-wrap">
                        @foreach($notices as $notice)
                            <div class="notice-list">
                                <div class="post-date bg-skyblue">{{ date('d-m-Y', strtotime($notice->created_at)) }}</div>
                                <h6 class="notice-title"><a
                                            href="{{ url($notice->file_path) }}">{{ $notice->title }}</a></h6>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var male = @json($male);
        var female = @json($female);

        var present = @json($present);
        var absent = @json($absent);
        var escaped = @json($escaped);
    </script>
@endsection