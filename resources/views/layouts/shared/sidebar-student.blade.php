@if(Auth::check())
    <div class="sidebar-main sidebar-menu-one sidebar-expand-md sidebar-color">
        <div class="mobile-sidebar-header d-md-none">
            <div class="header-logo">
                <a href="index.html"><img src="{{ asset('/template/img/logo1.png') }}" alt="logo"></a>
            </div>
        </div>
        @php
            $role = \Illuminate\Support\Facades\Auth::user()->role;
            $add = URL::current();
            $lib = 0;
            $ex = 0;
            $gpa = 0;
            $acc = 0;
            if(strpos($add, 'book'))
                $lib = 1;
            if(strpos($add, 'exams'))
                $ex = 1;
            if (strpos($add, 'gpa'))
                $gpa = 1;
            if (strpos($add, 'sectors') || strpos($add, 'expense') || strpos($add, 'income'))
                $acc = 1;
        @endphp
        <div class="sidebar-menu-content">
            <ul class="nav nav-sidebar-menu sidebar-toggle-view">
                <li class="nav-item">
                    <a href="{{ url($role.'/home') }}" class="nav-link"><i
                                class="flaticon-dashboard"></i><span>Dashboard</span></a>
                </li>

                @if($role == 'master')
                    <?php
                        $schools = \App\School::all();
                    ?>
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-school"></i><span>Schools</span></a>
                        <ul class="nav sub-group-menu">
                            <li class="nav-item">
                                <a href="{{url('master/new/create-school')}}" class="nav-link"><i class="fas fa-angle-right"></i>Create School</a>
                                <a href="{{url('master/home')}}" class="nav-link"><i class="fas fa-angle-right"></i>All Schools</a>
                            </li>
                        </ul>
                    </li>
                @endif


                @if($role == 'admin')
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-user-plus"></i><span>Attendance</span></a>
                        <ul class="nav sub-group-menu {{ Request::get('att') == 1 ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a href="#" class="nav-link"><i class="fas fa-angle-right"></i>Teachers Attendance</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('admin/school/sections?att=1') }}" class="nav-link"><i class="fas fa-angle-right"></i>Students Attendance</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link"><i class="fas fa-angle-right"></i>Staffs Attendance</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin/school/sections?course=1') }}" class="nav-link">
                            <i class="fas fa-school"></i><span>Class Details</span></a>
                    </li>
                @endif

                @if($role == 'student')
                    <li class="nav-item">
                        <a href="{{ url('student/attendances/0/' . Auth::user()->id . '/0') }}" class="nav-link">
                            <i class="fas fa-user-plus"></i><span>My Attendance</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('student/courses/0/'.Auth::user()->section_id) }}" class="nav-link">
                            <i class="fas fa-book-open"></i><span>My Courses</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('student/grades/'.Auth::user()->id) }}" class="nav-link">
                            <i class="fas fa-poll"></i><span>My Grade</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-file-invoice"></i><span>Payment History</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-bus"></i><span>Transport</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('student/notices-and-events') }}" class="nav-link"><i class="fas fa-exclamation-circle"></i><span>Events && Notices</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('student/user/'.\Auth::user()->id.'/notifications') }}" class="nav-link">
                            <i class="fas fa-envelope-open"></i><span>Messages</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-user"></i><span>Account</span></a>
                    </li>
                @endif
                @if($role != 'student' && $role != 'master')
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('users/'.Auth::user()->school->code.'/1/0')}}">
                            <i class="flaticon-classmates"></i> <span>Students</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('users/'.Auth::user()->school->code.'/0/1')}}">
                            <i class="flaticon-multiple-users-silhouette"></i><span>Teachers</span></a>
                    </li>
                @endif
                @if($role == 'admin')
                    <li class="nav-item">
                        <a href="{{ url('admin/all-department') }}" class="nav-link">
                            <i class="far fa-building"></i><span>All Departments</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin/academic/routine') }}" class="nav-link">
                            <i class="far fa-clock"></i><span>Class Routine</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin/grades/classes') }}" class="nav-link">
                            <i class="fas fa-poll-h"></i><span>Grades</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin/academic/syllabus') }}" class="nav-link">
                            <i class="fab fa-readme"></i><span>Syllabus</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin/academic/notice') }}" class="nav-link">
                            <i class="fas fa-exclamation-circle"></i><span>Notice</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin/academic/event') }}" class="nav-link">
                            <i class="fas fa-calendar-week"></i><span>Events</span></a>
                    </li>
                @endif

                @if($role == 'admin')
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-file-alt"></i><span>Exams</span></a>
                        <ul class="nav sub-group-menu {{ $ex == 1 ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('admin/exams/create') }}"><i class="fas fa-angle-right"></i><span>Add Examination</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('admin/exams/active') }}"><i class="fas fa-angle-right"></i><span>Active Exams</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('admin/exams') }}"><i class="fas fa-angle-right"></i><span>Manage Examinations</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-poll-h"></i><span>Manage GPA</span></a>
                        <ul class="nav sub-group-menu {{ $gpa == 1 ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('admin/gpa/all-gpa') }}"><i class="fas fa-angle-right"></i><span>All GPA</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('admin/gpa/create-gpa') }}"><i class="fas fa-angle-right"></i><span>Add New Grade System</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin/academic-settings') }}" class="nav-link">
                            <i class="fas fa-sliders-h"></i><span>Academic Settings</span></a>
                    </li>

                @endif

                @if($role == 'teacher')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('teacher/courses/'.Auth::user()->id.'/0') }}">
                            <i class="fas fa-book-medical"></i><span>My Courses</span></a>
                    </li>
                @endif
                @if($role == 'admin' || $role == 'accountant')

                    <li class="nav-item">
                        <a href="{{ url($role.'/fees/all') }}" class="nav-link">
                            <i class="fas fa-hand-holding-usd"></i><span>Fees Generators</span></a>
                    </li>


                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-file-invoice-dollar"></i><span>Manage Accounts</span></a>
                        <ul class="nav sub-group-menu {{ $acc == 1 ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a class="nav-link" href="{{url($role.'/users/'.Auth::user()->school->code.'/accountant')}}">
                                    <i class="fas fa-angle-right"></i><span>Accountant List</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url($role.'/sectors') }}">
                                    <i class="fas fa-angle-right"></i><span>Add Account Sector</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url($role.'/expense') }}">
                                    <i class="fas fa-angle-right"></i><span>Add New Expense</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url($role.'/expense-list') }}">
                                    <i class="fas fa-angle-right"></i><span>Expense List</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url($role.'/income') }}">
                                    <i class="fas fa-angle-right"></i><span>Add New Income</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url($role.'/income-list') }}">
                                    <i class="fas fa-angle-right"></i><span>Income List</span></a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if($role == 'admin' || $role == 'librarian')
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-book-open"></i><span>Manage Library</span></a>
                        <ul class="nav sub-group-menu menu-open {{ $lib==1 ? 'sub-group-active' : '' }}" style="display: block;">
                            <li class="nav-item">
                                <a href="{{url($role.'/users/'.Auth::user()->school->code.'/librarian')}}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Librarian List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url($role.'/all-books') }}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>All Books</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url($role.'/issued-books') }}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>All Issued Books</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url($role.'/issue-books') }}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Issue Book</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url($role.'/create/book') }}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Add Book</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
@endif