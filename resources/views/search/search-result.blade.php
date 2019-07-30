@extends('layouts.student-app')
@section('title','Search Result')
@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
            </li>
            <li class="text-capitalize">{{ \Auth::user()->role }} Dashboard</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-6 col-6-xxxl">
            <div class="card mb-4 dashboard-card-ten">
                <div class="card-body profile-info">
                    <div class="heading-layout1 mb-5">
                        <div class="item-title">
                            <h3 class="text-center">{{ $user->name }}</h3>
                        </div>
                    </div>
                    <div class="student-info">
                        <div class="media  media-none--xs">
                            <div class="row">
                                <div class="col-12 ">
                                    <div class="item-img offset-6 mt-5">
                                        <img src="{{url($user->pic_path)}}" class=" text-center" alt="student">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p>{{ $user->about }}</p>
                        <div class="info-table">
                            <table class="table text-wrap">
                                <tbody>
                                <tr>
                                    <td class="font-medium text-dark-medium">Gender:</td>
                                    <td class="text-capitalize">{{ ucfirst($user->gender) }}</td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">Blood Group:</td>
                                    <td class="text-capitalize">{{ ucfirst($user->blood_group) }}</td>
                                </tr>
                                <tr>
                                    @if(isset($user->studentInfo->father_name))
                                        <td class="font-medium text-dark-medium">Father's Name:</td>
                                        <td class="text-capitalize">{{ $user->studentInfo->father_name }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(isset($user->studentInfo->father_occupation))
                                        <td class="font-medium text-dark-medium">Father's Occupation:</td>
                                        <td class="text-capitalize">{{ $user->studentInfo->father_occupation }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(isset($user->studentInfo->mother_name))
                                        <td class="font-medium text-dark-medium">Mother's Name:</td>
                                        <td class="text-capitalize">{{ $user->studentInfo->mother_name }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(isset($user->studentInfo->mother_occupation))
                                        <td class="font-medium text-dark-medium">Mother's Occupation:</td>
                                        <td class="text-capitalize">{{ $user->studentInfo->mother_occupation }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(isset($user->studentInfo->birthday))
                                        <td class="font-medium text-dark-medium">Date of Birth:</td>
                                        <td>{{ date('d-m-Y', strtotime($user->studentInfo->birthday)) }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    @if(isset($user->student_info->religion))
                                        <td class="font-medium text-dark-medium">Religion:</td>
                                        <td class="text-capitalize">{{ ucfirst($user->student_info->religion) }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">E-Mail:</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">Admission Date:</td>
                                    <td class="text-capitalize">{{ $user->created_at}}</td>
                                </tr>
                                <tr>
                                    @if(isset($user->studentInfo->group))
                                        <td class="font-medium text-dark-medium">Group:</td>
                                        <td class="text-capitalize">{{ ucfirst($user->studentInfo->group) }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">Section:</td>
                                    <td class="text-capitalize">{{ $user->section_id }}</td>
                                </tr>
                                <tr>
                                    @if(isset($user->studentInfo->student_id))
                                        <td class="font-medium text-dark-medium">Roll:</td>
                                        <td>{{ $user->studentInfo->student_id }}</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">Address:</td>
                                    <td class="text-capitalize">{{ $user->address }}</td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">Phone:</td>
                                    <td>{{ $user->phone_number }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
                <div class="row">
                    <div class="col-xl-6 col-sm-6 col-6">
                        <div class="dashboard-summery-one mg-b-20">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="item-icon bg-light-green ">
                                        <i class="flaticon-classmates text-green"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="item-content">
                                        <div class="item-title">Class  </div>
                                        <div class="item-number"><span class="counter" data-num="{{ $section->class->class_number }}"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="dashboard-summery-one">
                            <div class="row">
                                <div class="col-6">
                                    <div class="item-icon bg-light-blue">
                                        <i class="flaticon-calendar text-blue"></i>
                                    </div>
                                </div>
                                <div class="col-6 mt-3">
                                    <div class="item-content">
                                        <div class="item-title">Section </div>
                                        <span style="color: #32998f">{{ $section->section_number }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="">
                <div class="card dashboard-card-three">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3 class="text-center">Attendance</h3>
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
                            <div class="student-count text-center mt-5">
                                <a class="btn-link text-teal" role="button" href="{{url(\Illuminate\Support\Facades\Auth::user()->role.'/attendances/0/'.$user->id.'/0')}}">View Attendance</a>
                            </div>
                        @else
                            <div style="text-align: center">
                                No Attendance record found
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card mt-5">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Student Courses</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table display text-wrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Course Name</th>
                                <th>Time</th>
                                <th>Room No</th>
                                <th>Course Teacher</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td>{{ $loop->index }}</td>
                                    <td>{{ $course->course_name }}</td>
                                    <td> {{ $course->course_time }} </td>
                                    <td> {{ $course->section->room_number }} </td>
                                    <td>
                                        <a class="text-teal" href="{{url('user/'.$course->teacher->student_code)}}">{{$course->teacher->name}}</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    var present = @json($present);
    var absent = @json($absent);
    var escaped = @json($escaped);
</script>