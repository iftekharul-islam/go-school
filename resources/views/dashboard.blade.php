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
        <div class="col-12">
            <div class="row">
                <div class="col-lg-12 col-md-6 col-xl-4">
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
                <div class="col-lg-12 col-md-6 col-xl-4">
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
                <div class="col-lg-12 col-md-6 col-xl-4">
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
                                        <div class="item-number"><span class="counter" data-num="{{ $present }}"></span><span>%</span></div>
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
                <div class="col-lg-5 mb-5">
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
                <div class="col-lg-7 mb-5">
                    <div class="card dashboard-card-eleven card-height-exams">
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
                                                <th>Class</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Result Published</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($exams as $key => $exam)
                                                <tr>
                                                    <td>{{ $exam->exam_name }}</td>
                                                    <td>{{ $exam->term }}</td>
                                                    <td>
                                                        @foreach($exam->myClasses as $key => $class)
                                                            {{ $class->classDetails->class_number}}
                                                            @if($key < count($exam->myClasses) - 1) ,@endif
                                                        @endforeach
                                                    </td>
                                                    <td>{{ date('d-m-Y', strtotime($exam->start_date)) }}</td>
                                                    <td>{{ date('d-m-Y',strtotime($exam->end_date)) }}</td>
                                                    <td>
                                                        @if ($exam->result_published)
                                                            @if (!empty($exam->result_file))
                                                                <a href="{{route('exams.download.result',['exam_id' => $exam->id])}}" title="Download" class="btn btn-info btn-lg"><i class="fas fa-download"></i></a>
                                                            @else
                                                                Yes
                                                            @endif
                                                        @else
                                                            No
                                                        @endif
                                                    </td>
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
        </div>
        <script>
            var present = @json($present);
            var absent = @json($absent);
            var escaped = @json($escaped);
        </script>
@endsection
