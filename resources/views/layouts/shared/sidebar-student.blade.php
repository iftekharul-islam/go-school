@if(Auth::check())
    <div class="sidebar-main sidebar-menu-one sidebar-expand-md sidebar-color">
        <div class="mobile-sidebar-header d-md-none">
            <div class="header-logo">
                <a href="index.html"><img src="{{ asset('/template/img/logo1.png') }}" alt="logo"></a>
            </div>
        </div>
        <div class="sidebar-menu-content">
            <ul class="nav nav-sidebar-menu sidebar-toggle-view">
                <li class="nav-item">
                    <a href="{{ url('home') }}" class="nav-link"><i
                                class="flaticon-dashboard"></i><span>Dashboard</span></a>
                </li>

                @if(Auth::user()-> role == 'master')
                    <?php
                        $schools = \App\School::all();
                    ?>
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-school"></i><span>Schools</span></a>
                        <ul class="nav sub-group-menu">
                            <li class="nav-item">
                                <a href="{{url('new/create-school')}}" class="nav-link"><i class="fas fa-angle-right"></i>Create School</a>
                                <a href="{{url('/home')}}" class="nav-link"><i class="fas fa-angle-right"></i>All Schools</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if(Auth::user()-> role == 'admin')
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-user-plus"></i><span>Attendance</span></a>
                        <ul class="nav sub-group-menu {{ (request()->is('school*')) ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a href="#" class="nav-link"><i class="fas fa-angle-right"></i>Teachers Attendance</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('school/sections?att=1') }}" class="nav-link"><i class="fas fa-angle-right"></i>Students Attendance</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link"><i class="fas fa-angle-right"></i>Staffs Attendance</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('school/sections?course=1') }}" class="nav-link">
                            <i class="fas fa-school"></i><span>Class Details</span></a>
                    </li>
                @endif

                @if(Auth::user()->role == 'student')
                    <li class="nav-item">
                        <a href="{{ url('attendances/0/' . Auth::user()->id . '/0') }}" class="nav-link">
                            <i class="fas fa-user-plus"></i><span>My Attendance</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('courses/0/'.Auth::user()->section_id) }}" class="nav-link">
                            <i class="fas fa-book-open"></i><span>My Courses</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('grades/'.Auth::user()->id) }}" class="nav-link">
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
                        <a href="{{ url('/notices-and-events') }}" class="nav-link"><i class="fas fa-exclamation-circle"></i><span>Events && Notices</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('user/'.\Auth::user()->id.'/notifications') }}" class="nav-link">
                            <i class="fas fa-envelope-open"></i><span>Messages</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-user"></i><span>Account</span></a>
                    </li>
                @endif
                @if(Auth::user()->role != 'student' && Auth::user()->role != 'master')
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('users/'.Auth::user()->school->code.'/1/0')}}">
                            <i class="flaticon-classmates"></i> <span>Students</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('users/'.Auth::user()->school->code.'/0/1')}}">
                            <i class="flaticon-multiple-users-silhouette"></i><span>Teachers</span></a>
                    </li>
                @endif
                @if(Auth::user()-> role == 'admin')
                    <li class="nav-item">
                        <a href="{{ url('all-department') }}" class="nav-link">
                            <i class="far fa-building"></i><span>All Departments</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('academic/routine') }}" class="nav-link">
                            <i class="far fa-clock"></i><span>Class Routine</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('grades/classes') }}" class="nav-link">
                            <i class="fas fa-poll-h"></i><span>Grades</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('academic/syllabus') }}" class="nav-link">
                            <i class="fab fa-readme"></i><span>Syllabus</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('academic/notice') }}" class="nav-link">
                            <i class="fas fa-exclamation-circle"></i><span>Notice</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('academic/event') }}" class="nav-link">
                            <i class="fas fa-calendar-week"></i><span>Events</span></a>
                    </li>
                @endif

                @if(Auth::user()->role == 'admin')
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-file-alt"></i><span>Exams</span></a>
                        <ul class="nav sub-group-menu {{ (request()->is('exams*')) ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('exams/create') }}"><i class="fas fa-angle-right"></i><span>Add Examination</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('exams/active') }}"><i class="fas fa-angle-right"></i><span>Active Exams</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('exams') }}"><i class="fas fa-angle-right"></i><span>Manage Examinations</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-poll-h"></i><span>Manage GPA</span></a>
                        <ul class="nav sub-group-menu {{ (request()->is('gpa*')) ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('gpa/all-gpa') }}"><i class="fas fa-angle-right"></i><span>All GPA</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('gpa/create-gpa') }}"><i class="fas fa-angle-right"></i><span>Add New Grade System</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('academic-settings') }}" class="nav-link">
                            <i class="fas fa-sliders-h"></i><span>Academic Settings</span></a>
                    </li>

                @endif

                @if(Auth::user()->role == 'teacher')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('courses/'.Auth::user()->id.'/0') }}">
                            <i class="fas fa-book-medical"></i><span>My Courses</span></a>
                    </li>
                @endif
                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'accountant')

                    <li class="nav-item">
                        <a href="{{ url('fees/all') }}" class="nav-link">
                            <i class="fas fa-hand-holding-usd"></i><span>Fees Generators</span></a>
                    </li>


                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-file-invoice-dollar"></i><span>Manage Accounts</span></a>
                        <ul class="nav sub-group-menu {{ (request()->is('accounts*')) ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('users/'.Auth::user()->school->code.'/accountant')}}">
                                    <i class="fas fa-angle-right"></i><span>Accountant List</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('accounts/sectors') }}">
                                    <i class="fas fa-angle-right"></i><span>Add Account Sector</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('accounts/expense') }}">
                                    <i class="fas fa-angle-right"></i><span>Add New Expense</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('accounts/expense-list') }}">
                                    <i class="fas fa-angle-right"></i><span>Expense List</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('accounts/income') }}">
                                    <i class="fas fa-angle-right"></i><span>Add New Income</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('accounts/income-list') }}">
                                    <i class="fas fa-angle-right"></i><span>Income List</span></a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'librarian')
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-book-open"></i><span>Manage Library</span></a>
                        <ul class="nav sub-group-menu menu-open {{ (request()->is('library*')) ? 'sub-group-active' : '' }}" style="display: block;">
                            <li class="nav-item">
                                <a href="{{url('users/'.Auth::user()->school->code.'/librarian')}}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Librarian List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('library.books.index') }}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>All Books</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('library/issued-books') }}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>All Issued Books</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('library/issue-books') }}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Issue Book</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('library.books.create') }}" class="nav-link"><i
                                            class="fas fa-angle-right"></i>Add Book</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
@endif