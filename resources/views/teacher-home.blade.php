@extends('layouts.student-app')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>{{ \Auth::user()->role }}</li>
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
                            <div class="item-number"><span class="counter" data-num="{{ $totalClasses }}"></span></div>
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
            <div class="card dashboard-card-three">
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
    @if(\Auth::user()->role == 'admin')
        {{ $present }}
        <div class="row">
            <div class="col-lg-12">
                <div class="card dashboard-card-eleven">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>All Students</h3>
                            </div>
                        </div>
                        <div class="table-box-wrap">
                            <div class="table-responsive student-table-box">
                                <table class="table display data-table text-wrap">
                                    <thead>
                                    <tr>
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
                                            <td class="text-center"><img style="max-width: 50px;" src="{{ $student->pic_path }}" alt="student"></td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ ucfirst($student->gender) }}</td>
                                            <td><small><a class="btn btn-xs btn-info" role="button" href="{{url('attendances/0/'.$student->id.'/0')}}">View Attendance</a></small></td>
                                            <td>{{ ucfirst($student['school']['medium']) }}</td>
                                            <td>{{ ucfirst($student['section']['section_number']) }} </td>
                                            <td>{{ ucfirst($student['section']['class_id']) }}</td>
                                            <td>{{ isset($student->studentInfo) ? ucfirst($student->studentInfo['father_name']) : null }}</td>
                                            <td>{{ isset($student->studentInfo) ? ucfirst($student->studentInfo['mother_name']) : null }}</td>
                                            <td>{{ ucfirst($student->blood_group) }}</td>
                                            <td>{{ ucfirst($student->phone_number) }}</td>
                                            <td>{{ ucfirst($student->email) }}</td>
                                            <td>{{ ucfirst($student->address) }}</td>
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
    @endif

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
                                    @foreach($courses_student as $c)
                                        @foreach($c['section']['users'] as $user)
                                            <tr>
                                                {{--                                        @if($key < 10)--}}
                                                <td>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input">
                                                        <label class="form-check-label">#{{ $user->code }}</label>
                                                    </div>
                                                </td>
                                                <td class="text-center"><img style="max-width: 50px;" src="{{ $user->pic_path }}" alt="student"></td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ ucfirst($user->gender) }}</td>
                                                <td><small><a class="btn btn-xs btn-info" role="button" href="{{url('attendances/0/'.$user->id.'/0')}}">View Attendance</a></small></td>
                                                <td>{{ ucfirst($user['school']['medium']) }}</td>
                                                <td>{{ ucfirst($user['section']['section_number']) }} </td>
                                                <td>{{ ucfirst($user['section']['class_id']) }}</td>
                                                <td>{{ isset($user->studentInfo) ? ucfirst($user->studentInfo['father_name']) : null }}</td>
                                                <td>{{ isset($user->studentInfo) ? ucfirst($user->studentInfo['mother_name']) : null }}</td>
                                                <td>{{ ucfirst($user->blood_group) }}</td>
                                                <td>{{ ucfirst($user->phone_number) }}</td>
                                                <td>{{ ucfirst($user->email) }}</td>
                                                <td>{{ ucfirst($user->address) }}</td>
                                                <td>

                                                </td>
                                                {{--                                        @endif--}}
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
        <div class="table-responsive">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <table class="table display dataTable text-wrap" style="border: 0px;">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Code</th>
                    <th>Author</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Action</th>
                    <th></th>
                </tr>
                </thead>
                @foreach($books as $book)
                    <tr>
                        <td>{{ ($loop->index + 1) }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->book_code }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->type }}</td>
                        <td>{{ $book->quantity }}</td>
                        <td>
                            <div class="form-group">
                                <a href="{{ route('library.books.show', $book->id) }}" class="btn-fill-lg bg-blue-dark btn-hover-yellow">
                                    details
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="paginate123 mt-5 float-right">
                {{ $books->links() }}
            </div>
        </div>
    @endif
    @if(\Auth::user()->role == 'accountant')
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>All Fees Collectiont</h3>
                        {{--                    <a class="btn btn-success btn-lg" href="{{url('create-school')}}">Manage School</a>--}}
                    </div>
                </div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @component('components.new-fees-list',['fees'=>$fees])
                @endcomponent
            </div>
        </div>
    @endif
    <script>
        var male = @json($male);
        var female = @json($female);

        var present = @json($present);
        var absent = @json($absent);
    </script>
@endsection