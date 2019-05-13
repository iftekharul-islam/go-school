@extends('layouts.student-app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>Teachers</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <div class="row">
        <!-- Dashboard summery Start Here -->
        <div class="col-12 col-4-xxxl">
            <div class="row">
                <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                    <div class="dashboard-summery-two">
                        <div class="item-icon bg-light-magenta">
                            <i class="flaticon-classmates text-magenta"></i>
                        </div>
                        <div class="item-content">
                            <div class="item-number"><span class="counter" data-num="{{ $totalStudents }}"></span></div>
                            <div class="item-title">Total Students</div>
                        </div>
                    </div>
                </div>
                <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                    <div class="dashboard-summery-two">
                        <div class="item-icon bg-light-blue">
                            <i class="flaticon-shopping-list text-blue"></i>
                        </div>
                        <div class="item-content">
                            <div class="item-number"><span class="counter" data-num="{{ $exams->count() }}"></span></div>
                            <div class="item-title">Total Exams</div>
                        </div>
                    </div>
                </div>
                <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                    <div class="dashboard-summery-two">
                        <div class="item-icon bg-light-yellow">
                            <i class="flaticon-maths-class-materials-cross-of-a-pencil-and-a-ruler text-green"></i>
                        </div>
                        <div class="item-content">
                            <div class="item-number"><span class="counter" data-num="{{ $totalClasses }}">23,890</span></div>
                            <div class="item-title">Total Classes</div>
                        </div>
                    </div>
                </div>
                <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                    <div class="dashboard-summery-two">
                        <div class="item-icon bg-light-red">
                            <i class="flaticon-books text-blue"></i>
                        </div>
                        <div class="item-content">
                            <div class="item-number"><span class="counter" data-num="{{ $totalSections }}">21,02,050</span></div>
                            <div class="item-title">Total Sections</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dashboard summery End Here -->
        <!-- Students Chart End Here -->
        <div class="col-lg-6 col-4-xxxl col-xl-6">
            <div class="card dashboard-card-three">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Students</h3>
                        </div>
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-expanded="false">...</a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                            </div>
                        </div>
                    </div>
                    <div class="doughnut-chart-wrap">
                        <canvas id="student-doughnut-chart" width="100" height="270"></canvas>
                    </div>
                    <div class="student-report">
                        <div class="student-count pseudo-bg-blue">
                            <h4 class="item-title">Female Students</h4>
                            <div class="item-number">{{ $female }}</div>
                        </div>
                        <div class="student-count pseudo-bg-yellow">
                            <h4 class="item-title">Male Students</h4>
                            <div class="item-number">{{ $male }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Students Chart End Here -->
        <!-- Notice Board Start Here -->
        <div class="col-lg-6 col-4-xxxl col-xl-6">
            <div class="card dashboard-card-six">
                <div class="card-body">
                    <div class="heading-layout1 mg-b-17">
                        <div class="item-title">
                            <h3>Notices</h3>
                        </div>
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-expanded="false">...</a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                            </div>
                        </div>
                    </div>
                    <div class="notice-box-wrap">
                        @foreach($notices as $notice)
                            <div class="notice-list">
                                <div class="post-date bg-skyblue">{{ date('d-m-Y', strtotime($notice->created_at)) }}</div>
                                <h6 class="notice-title"><a href="{{ url($notice->file_path) }}">{{ $notice->title }}</a></h6>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Notice Board End Here -->
    </div>
    <!-- Student Table Area Start Here -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card dashboard-card-eleven">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>All Students</h3>
                        </div>
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-expanded="false">...</a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-box-wrap">
                        <form class="search-form-box">
                            <div class="row gutters-8">
                                <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                    <input type="text" placeholder="Search by Roll ..." class="form-control">
                                </div>
                                <div class="col-4-xxxl col-xl-4 col-lg-4 col-12 form-group">
                                    <input type="text" placeholder="Search by Name ..." class="form-control">
                                </div>
                                <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                    <input type="text" placeholder="Search by Class ..." class="form-control">
                                </div>
                                <div class="col-1-xxxl col-xl-2 col-lg-2 col-12 form-group">
                                    <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive student-table-box">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkAll">
                                            <label class="form-check-label">Code</label>
                                        </div>
                                    </th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Attendance</th>
                                    <th>Version</th>
                                    <th>Section</th>
                                    <th>Class</th>
                                    <th>Father</th>
                                    <th>Mother</th>
                                    <th>Blood</th>
                                    <th>Phone</th>
                                    <th>E-mail</th>
                                    <th>Address</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($allStudents as $key => $student)
                                    <tr>
{{--                                        @if($key < 10)--}}
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input">
                                                    <label class="form-check-label">#{{ $student->code }}</label>
                                                </div>
                                            </td>
                                            <td class="text-center"><img style="max-width: 50px;" src="{{ $student->pic_path }}" alt="student"></td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->gender }}</td>
                                            <td><small><a class="btn btn-xs btn-info" role="button" href="{{url('attendances/0/'.$student->id.'/0')}}">View Attendance</a></small></td>
                                            <td>{{ $student['school']['medium'] }}</td>
                                            <td>{{ $student['section']['section_number'] }} </td>
                                            <td>{{ $student['section']['class_id'] }}</td>
                                            <td>{{ isset($student->studentInfo) ? $student->studentInfo['father_name'] : null }}</td>
                                            <td>{{ isset($student->studentInfo) ? $student->studentInfo['mother_name'] : null }}</td>
                                            <td>{{ $student->blood_group }}</td>
                                            <td>{{ $student->phone_number }}</td>
                                            <td>{{ $student->email }}</td>
                                            <td>{{ $student->address }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="#" class="dropdown-toggle"
                                                       data-toggle="dropdown" aria-expanded="false">
                                                                        <span
                                                                                class="flaticon-more-button-of-three-dots"></span>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#"><i
                                                                    class="fas fa-times text-orange-red"></i>Close</a>
                                                        <a class="dropdown-item" href="#"><i
                                                                    class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                        <a class="dropdown-item" href="#"><i
                                                                    class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                    </div>
                                                </div>
                                            </td>
{{--                                        @endif--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection