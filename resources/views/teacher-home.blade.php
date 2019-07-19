@extends('layouts.student-app')
@section('title','Dashboard')
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
    <!-- Breadcubs Area End Here -->
    <div class="false-height">
        <div class="row">
            <!-- Dashboard summery Start Here -->
            <div class="col-12 col-4-xxxl">
                <div class="row">
                    <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                        <div class="dashboard-summery-two">
                            <div class="item-icon bg-light-teal-transparent">
                                <i class="flaticon-classmates text-light"></i>
                            </div>
                            <div class="item-content">
                                <div class="item-number"><span class="counter" data-num="{{ $totalStudents }}"></span></div>
                                <div class="item-title">Total Students</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                        <div class="dashboard-summery-two">
                            <div class="item-icon bg-light-teal-transparent">
                                <i class="flaticon-shopping-list text-light"></i>
                            </div>
                            <div class="item-content">
                                <div class="item-number"><span class="counter" data-num="{{ $exams->count() }}"></span></div>
                                <div class="item-title">Total Exams</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                        <div class="dashboard-summery-two">
                            <div class="item-icon bg-light-teal-transparent">
                                <i class="flaticon-maths-class-materials-cross-of-a-pencil-and-a-ruler text-light"></i>
                            </div>
                            <div class="item-content">
                                <div class="item-number"><span class="counter" data-num="{{ $totalClasses }}"></span></div>
                                <div class="item-title">Total Classes</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                        <div class="dashboard-summery-two">
                            <div class="item-icon bg-light-teal-transparent">
                                <i class="flaticon-books text-light"></i>
                            </div>
                            <div class="item-content">
                                <div class="item-number"><span class="counter" data-num="{{ $totalSections }}"></span></div>
                                <div class="item-title">Total Sections</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dashboard summery End Here -->
            <!-- Students Chart End Here -->
            <div class="col-lg-6 col-4-xxxl col-xl-6">
                <div class="card dashboard-card-three" style="min-height: 484px !important;">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Students</h3>
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
                <div class="card dashboard-card-six" style="min-height: 484px !important;">
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
                                            <div class="post-date bg-skyblue">{{ date('d-m-Y', strtotime($notice->created_at)) }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- Notice Board End Here -->
        </div>

        @if(\Auth::user()->role == 'teacher')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card dashboard-card-eleven">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>All Students Under My Classes</h3>
                                </div>
                            </div>
                            <div class="table-box-wrap">
                                <div class="table-responsive student-table-box">
                                    <table class="table table-data-div text-wrap">
                                        <thead>
                                        <tr>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Version</th>
                                            <th>Section</th>
                                            <th>Class</th>
                                            <th>Phone</th>
                                            <th>E-mail</th>
                                            <th>Attendance</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($courses_student as $c)
                                            @foreach($c['section']['users'] as $user)
                                                <tr>
                                                    <td class="text-center"><img style="max-width: 50px;" src="{{ $user->pic_path }}" alt="student"></td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ ucfirst($user['school']['medium']) }}</td>
                                                    <td>{{ ucfirst($user['section']['section_number']) }} </td>
                                                    <td>{{ ucfirst($user['section']['class_id']) }}</td>
                                                    <td>{{ ucfirst($user->phone_number) }}</td>
                                                    <td>{{ ucfirst($user->email) }}</td>
                                                    <td><small><a class="button button--text float-left" role="button" href="{{url('teacher/attendances/0/'.$user->id.'/0')}}">View Attendance</a></small></td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(\Auth::user()->role == 'librarian')
            <div class="card false-height">
                <div class="card-body">
                    <div class="table-box-wrap">
                        <h3 style="text-align: center" class="mt-5">All Books</h3>
                        <div class="table-responsive student-table-box">
                            <table class="table table-data-div text-wrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Code</th>
                                    <th>Author</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                @foreach($books as $book)
                                    <tr>
                                        <td>{{ ($loop->index + 1) }}</td>
                                        <td>
                                            <a href="{{ url('/librarian/book/'.$book->id) }}" class="text-teal">{{ $book->title }}</a>
                                        </td>
                                        <td>{{ $book->book_code }}</td>
                                        <td>{{ $book->author }}</td>
                                        <td>{{ $book->type }}</td>
                                        <td>{{ $book->quantity }}</td>
                                        <td>
                                            <div class="form-group">
                                                <a href="{{ url('/librarian/book/'.$book->id) }}" class="button button--text float-left">
                                                    Details
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <script>
            var male = @json($male);
            var female = @json($female);
        </script>
    </div>
@endsection