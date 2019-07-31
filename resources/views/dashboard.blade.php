@extends('layouts.student-app')
@section('title','Dashboard')
@section('content')
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
            </li>
            <li>Student Dashboard</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->

    <div class="row">
        <div class="col-4 col-4-xxxl">
            <div class="card mb-4 dashboard-card-ten">
                <div class="card-body profile-info">
                    <div class="heading-layout1 mb-5">
                        <div class="item-title">
                            <h3 class="">About Me</h3>
                        </div>
                    </div>
                    <div class="student-info">
                        <div class="media  media-none--xs">
                            <div class="row">
                                <div class="col-12 ">
                                    <div class="item-img offset-6 mt-5">
                                        <img src="{{url($student->pic_path)}}" class=" text-center" alt="student">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="media-body mt-5">
                            <h3 class="item-title text-center text-capitalize">{{ Auth::user()->name }}</h3>
                        </div>
                        <p>{{ $student->about }}</p>
                        <div class="info-table">
                            <table class="table text-wrap">
                                <tbody>
                                <tr>
                                    <td class="font-medium text-dark-medium">Gender:</td>
                                    <td class="text-capitalize">{{ ucfirst($student->gender) }}</td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">Blood Group:</td>
                                    <td class="text-capitalize">{{ ucfirst($student->blood_group) }}</td>
                                </tr>
                                <tr>
                                    @if(isset($student_info->father_name))
                                        <td class="font-medium text-dark-medium">Father's Name:</td>
                                        <td class="text-capitalize">{{ $student_info->father_name }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(isset($student_info->father_occupation))
                                        <td class="font-medium text-dark-medium">Father's Occupation:</td>
                                        <td class="text-capitalize">{{ $student_info->father_occupation }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(isset($student_info->mother_name))
                                        <td class="font-medium text-dark-medium">Mother's Name:</td>
                                        <td class="text-capitalize">{{ $student_info->mother_name }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(isset($student_info->mother_occupation))
                                        <td class="font-medium text-dark-medium">Mother's Occupation:</td>
                                        <td class="text-capitalize">{{ $student_info->mother_occupation }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(isset($student_info->birthday))
                                        <td class="font-medium text-dark-medium">Date of Birth:</td>
                                        <td>{{ date('d-m-Y', strtotime($student_info->birthday)) }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(isset($student_info->religion))
                                        <td class="font-medium text-dark-medium">Religion:</td>
                                        <td class="text-capitalize">{{ ucfirst($student_info->religion) }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">E-Mail:</td>
                                    <td>{{ $student->email }}</td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">Admission Date:</td>
                                    <td class="text-capitalize">{{ $student->created_at}}</td>

                                </tr>
                                <tr>
                                    @if(isset($student_info->group))
                                        <td class="font-medium text-dark-medium">Group:</td>
                                        <td class="text-capitalize">{{ ucfirst($student_info->group) }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">Section:</td>
                                    <td class="text-capitalize">{{ $student->section_id }}</td>
                                </tr>
                                <tr>
                                    @if(isset($student_info->student_id))
                                        <td class="font-medium text-dark-medium">Roll:</td>
                                        <td>{{ $student_info->student_id }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">Address:</td>
                                    <td class="text-capitalize">{{ $student->address }}</td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">Phone:</td>
                                    <td>{{ $student->phone_number }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{--                    @endif--}}
                </div>
            </div>
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

                            <div class="student-count pseudo-bg-present">
                                <h4 class="item-title">Present</h4>
                                <div class="item-number">{{ $present }}%</div>
                            </div>

                            <div class="student-count pseudo-bg-escaped">
                                <h4 class="item-title">Escaped</h4>
                                <div class="item-number">{{ $escaped }}%</div>
                            </div>
                            <div class="student-count pseudo-bg-absent">
                                <h4 class="item-title">Absent</h4>
                                <div class="item-number">{{ $absent }}%</div>
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
        <div class="col-8 col-8-xxxl">
            <div class="row">
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
                                        <div class="item-number"><span class="counter" data-num="{{ $present }}"></span><span>{{ $present }}%</span></div>
                                    @else
                                        No Record
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-5">
                    <div class="card dashboard-card-eleven">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>All Exam Schedule</h3>
                                </div>
                            </div>
                            @if(count($exams) > 0)
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
                            @else
                                <h4 class="text-center">No Exam Found</h4>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6-xxxl col-6">
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
                                        <div class="row">
                                            <div class="col-8">
                                                <h6 class="notice-title"><a href="{{ url($event->file_path) }}">{{ $event->title }}</a></h6>
                                            </div>
                                            <div class="col-4">
                                                <div class="post-date bg-skyblue">{{ date('d-m-Y', strtotime($event->created_at)) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6-xxxl col-6">
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
                                        <div class="row">
                                            <div class="col-8">
                                                <h6 class="notice-title"><a href="{{ url($notice->file_path) }}">{{ $notice->title }}</a></h6>
                                            </div>
                                            <div class="col-4">
                                                <div class="">{{ date('d-m-Y', strtotime($notice->created_at)) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>

            var present = @json($present);
            var absent = @json($absent);
            var escaped = @json($escaped);
        </script>
@endsection
