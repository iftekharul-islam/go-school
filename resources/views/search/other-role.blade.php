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
        <div class="col-5 col-5-xxxl">
            <div class="card mb-4 dashboard-card-ten">
                <div class="card-body profile-info">
                    <div class="heading-layout1 mb-5">
                        <div class="item-title">
                            <h3 class="text-center">{{ $user->name }}</h3>
                        </div>
                    </div>
                    <div class="student-info">
                        <div class="media  media-none--xs">
                            <div class="item-img mb-5">
                                @if(!empty($user->pic_path))
                                    <img src="{{url($user->pic_path)}}" alt="student">
                                @else
                                    <img src="{{ asset('template/img/user-default.png') }}" alt="user">
                                @endif
                            </div>
                        </div>
                        <p>{{ $user->about }}</p>
                        <div class="info-table">
                            <table class="table text-wrap">
                                <tbody>
                                <tr>
                                    <td class="font-medium text-dark-medium">E-Mail:</td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">Role:</td>
                                    <td>{{ $user->role }}</td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">Gender:</td>
                                    <td class="text-capitalize">{{ ucfirst($user->gender) }}</td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">Blood Group:</td>
                                    <td class="text-capitalize">{{ ucfirst($user->blood_group) }}</td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">Nationality:</td>
                                    <td>{{ $user->nationality }}</td>
                                </tr>
                                @if($user->role == 'teacher')
                                    <tr>
                                        <td class="font-medium text-dark-medium">Class Teacher 0f Section:</td>
                                        <td class="text-capitalize">{{ $user->section->section_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Department name:</td>
                                        <td class="text-capitalize">{{ $user->department->department_name }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="font-medium text-dark-medium">Phone:</td>
                                    <td>{{ $user->phone_number }}</td>
                                </tr>
                                <tr>
                                    <td class="font-medium text-dark-medium">Address:</td>
                                    <td class="text-capitalize">{{ $user->address }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card dashboard-card-three">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3 class="text-center">Attendance</h3>
                        </div>
                    </div>
                    @if(!empty($present))
                        <div class="doughnut-chart-wrap">
                            <canvas id="student-doughnut-chart3" width="100" height="270"></canvas>
                        </div>
                        <div class="student-report">

                            <div class="student-count pseudo-bg-present">
                                <h4 class="item-title">Present</h4>
                                <div class="item-number">{{ $present }}%</div>
                            </div>

                            <div class="student-count pseudo-bg-absent">
                                <h4 class="item-title">Absent</h4>
                                <div class="item-number">{{ $absent }}%</div>
                            </div>
                        </div>
                        <div class="student-count text-center mt-5">
                            <a class="btn-link text-teal" role="button" href="{{url('admin/staff/attendance/'.$user->id)}}">View Attendance</a>
                        </div>
                    @else
                        <div style="text-align: center">
                            No Attendance record found
                        </div>
                    @endif
                </div>
            </div>
            @if($user->role == 'teacher' && count($courses) > 0)
                <div class="card height-auto mt-5">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Teacher Courses</h3>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table display text-wrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Course Name</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Room</th>
                                    <th>Course Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($courses as $course)
                                    <tr>
                                        <td>{{ $loop->index }}</td>
                                        <td>{{ $course->course_name }}</td>
                                        <td>{{ $course->section->class->class_number }}</td>
                                        <td>{{ $course->section->section_number }}</td>
                                        <td>{{ $course->section->room_number }}</td>
                                        <td>{{ $course->course_time }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

<script>
    var present = @json($present);
    var absent = @json($absent);
</script>