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

                @if(Auth::user()-> role == 'admin')
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="flaticon-checklist"></i><span>Attendance</span></a>
                        <ul class="nav sub-group-menu">
                            <li class="nav-item">
                                <a href="#" class="nav-link"><i class="fas fa-angle-right"></i>Teacher Attendance</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('school/sections?att=1') }}" class="nav-link"><i class="fas fa-angle-right"></i>Students Attendance</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link"><i class="fas fa-angle-right"></i>Staff Attendance</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('school/sections?course=1') }}" class="nav-link"><i
                                    class="flaticon-checklist"></i><span>Classes & Section</span></a>
                    </li>
                @endif

                @if(Auth::user()->role == 'student')
                    <li class="nav-item">
                        <a href="{{ url('attendances/0/' . Auth::user()->id . '/0') }}" class="nav-link"><i
                                    class="flaticon-checklist"></i><span>My Attendance</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('courses/0/'.Auth::user()->section_id) }}" class="nav-link"><i
                                    class="flaticon-open-book"></i><span>My Courses</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('grades/'.Auth::user()->id) }}" class="nav-link"><i
                                    class="flaticon-technological"></i><span>My Grade</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i
                                    class="flaticon-technological"></i><span>Payment History</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i
                                    class="flaticon-bus-side-view"></i><span>Transport</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/all-notice') }}" class="nav-link"><i
                                    class="flaticon-script"></i><span>Notice</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('user/'.\Auth::user()->id.'/notifications') }}" class="nav-link"><i
                                    class="flaticon-chat"></i><span>Messages</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i
                                    class="flaticon-settings"></i><span>Account</span></a>
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
                        <a href="{{ url('academic/routine') }}" class="nav-link"><i
                                    class="flaticon-checklist"></i><span>Class Routine</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('grades/all-exams-grade') }}" class="nav-link"><i
                                    class="flaticon-checklist"></i><span>Grades</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('academic/syllabus') }}" class="nav-link"><i
                                    class="flaticon-checklist"></i><span>Syllabus</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('academic/notice') }}" class="nav-link"><i
                                    class="flaticon-checklist"></i><span>Notice</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('academic/event') }}" class="nav-link"><i
                                    class="flaticon-checklist"></i><span>Events</span></a>
                    </li>
                @endif

                @if(Auth::user()->role == 'admin')
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="flaticon-dashboard"></i><span>Exams</span></a>
                        <ul class="nav sub-group-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('exams/create') }}"><span>Add Examination</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('exams/active') }}"><span>Active Exams</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('exams') }}"><span>Manage Examinations</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="flaticon-dashboard"></i><span>Manage GPA</span></a>
                        <ul class="nav sub-group-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('gpa/all-gpa') }}"><span>All GPA</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('gpa/create-gpa') }}"><span>Add New GPA</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('create-school') }}" class="nav-link"><i
                                    class="flaticon-settings"></i><span>Academic Settings</span></a>
                    </li>

                @endif

                @if(Auth::user()->role == 'teacher')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('courses/'.Auth::user()->id.'/0') }}"><i
                                    class="flaticon-open-book"></i>
                            <span>My Courses</span></a>
                    </li>
                @endif
                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'accountant')
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="flaticon-dashboard"></i><span>Fees Generators</span></a>
                        <ul class="nav sub-group-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('fees/all') }}"><span>Generate Form</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('fees/create') }}"><span>Add Fee Field</span></a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="flaticon-dashboard"></i><span>Manage Accounts</span></a>
                        <ul class="nav sub-group-menu">
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('users/'.Auth::user()->school->code.'/accountant')}}">
                                    <span>Accountant List</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('accounts/sectors') }}">
                                    <span>Add Account Sector</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('accounts/expense') }}">
                                    <span>Add New Expense</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('accounts/expense-list') }}">
                                    <span>Expense List</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('accounts/income') }}">
                                    <span>Add New Income</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('accounts/income-list') }}">
                                    <span>Income List</span></a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'librarian')
                    <li class="nav-item sidebar-nav-item active">
                        <a href="#" class="nav-link"><i class="flaticon-books"></i><span>Manage Library</span></a>
                        <ul class="nav sub-group-menu menu-open" style="display: block;">
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