@if(Auth::check())
    <div class="sidebar-main sidebar-menu-one sidebar-expand-md sidebar-color">
        <div class="mobile-sidebar-header d-md-none">
            <div class="p-4 text-center">
                <a href="/"><img src="{{ asset('/template/img/logo1.png') }}" alt="logo" class="center"></a>
            </div>
        </div>
        @php
            $role = \Illuminate\Support\Facades\Auth::user()->role;
            $add = URL::current();
            $lib = 0;
            $ex = 0;
            $gpa = 0;
            $acc = 0;
            $ac = 0;
            $std = 0;
            $all_student = 0;
            $teacher = 0;
            $department = 0;
            $class = 0;
            $academic = 0;
            if (strpos($add, 'book') || strpos($add, 'librarian') || strpos($add, 'new-librarian'))
                $lib = 1;
            if (strpos($add, 'exams'))
                $ex = 1;
            if (strpos($add, 'gpa'))
                $gpa = 1;
            if (strpos($add, 'sectors') || strpos($add, 'expense') || strpos($add, 'income') ||  strpos($add, 'accountant') || strpos($add, 'fee-types') || strpos($add, 'fee-collection') || strpos($add, 'fee-discount') || strpos($add, 'fee-master'))
                $acc = 1;
            if (strpos($add, 'fee-types') || strpos($add, 'fee-discount') || strpos($add, 'fee-master') || strpos($add, 'fee-collection') || strpos($add, 'fees-summary'))
                $ac = 1;
            if (( strpos($add, 'users/') &&  Request::get('student') == 1 )   || strpos($add, 'student-message') || strpos($add, 'new-student') || strpos($add, 'import-student'))
                $std = 1;
            if (strpos($add, 'users/'))
                $all_student = 1;
            if ((strpos($add, 'users/') && Request::get('teacher'))  || strpos($add,'new-teacher'))
                $teacher = 1;
            if (strpos($add,'all-department')  || strpos($add,'create-department'))
                $department = 1;
            if (strpos($add,'routine')  || Request::get('course') == 1 || strpos($add,'manage-class'))
                $class = 1;
            if (strpos($add, 'classes')  || (strpos($add, 'syllabus')) || strpos($add, 'notice') || (strpos($add, 'event')) || (strpos($add, 'create-admit-card')))
                $academic = 1;
        @endphp
        <div class="sidebar-menu-content">
            <ul class="nav nav-sidebar-menu sidebar-toggle-view">
                <li class="nav-item">
                    <a href="{{ url($role.'/home') }}" class="nav-link "><i class="flaticon-dashboard"></i><span>Dashboard</span></a>
                </li>

                @if ($role == 'master')
                    <?php
                    $schools = \App\School::all();
                    ?>
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-school"></i><span>Schools</span></a>
                        <ul class="nav sub-group-menu {{ (request()->is('master/new*')) ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a href="{{url('master/new/create-school')}}"
                                   class="nav-link {{ (request()->is('master/new/create-school')) ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>Create School</a>
                                <a href="{{url('master/new/all-school')}}"
                                   class="nav-link {{ (request()->is('master/new/all-school')) ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>All Schools</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if ($role == 'admin')
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-user-plus"></i><span>Attendance</span></a>
                        <ul class="nav sub-group-menu {{ Request::get('att') ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a href="{{ url('admin/staff/teacher-attendance?att=2') }}"
                                   class="nav-link {{ (request()->is('admin/staff/teacher-attendance')) ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>Teachers Attendance</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('admin/staff/attendance?att=3') }}"
                                   class="nav-link {{ (request()->is('admin/staff/attendance')) ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>Staff Attendance</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::get('att') == 1 ? 'menu-active' : '' }}"
                                   href="{{ url('admin/school/sections?att=1') }}"><i class="fas fa-angle-right"></i>Students
                                    Attendance</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::get('att') == 1 ? 'menu-active' : '' }}"
                                   href="{{ route('configure.attendance.time') }}"><i class="fas fa-angle-right"></i>Configuration</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if ($role == 'student')
                    <li class="nav-item">
                        <a href="{{ url('student/attendances/0/' . Auth::user()->id . '/0') }}" class="nav-link">
                            <i class="far fa-calendar-check"></i><span>My Attendance</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('student/courses/0/'.Auth::user()->section_id) }}"
                           class="nav-link {{ (request()->is('student/courses/0/'.Auth::user()->section_id)) ? 'menu-active' : '' }}">
                            <i class="fas fa-book-open"></i><span>My Courses</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('student/grades/'.Auth::user()->id) }}"
                           class="nav-link {{ (request()->is('student/grades/'.Auth::user()->id)) ? 'menu-active' : '' }}">
                            <i class="fas fa-poll"></i><span>My Grade</span></a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('student/notices-and-events') }}"
                           class="nav-link {{ (request()->is('student/notices-and-events')) ? 'menu-active' : '' }}"><i
                                    class="fas fa-exclamation-circle"></i><span>Events & Notices</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('student/user/notifications/'.\Auth::user()->id) }}"
                           class="nav-link {{ (request()->is('student/user/notifications/'.\Auth::user()->id)) ? 'menu-active' : '' }}">
                            <i class="fas fa-envelope-open"></i><span>Messages</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $ac == 1 ? 'menu-active' : '' }}"
                           href="{{ route('fees.summary') }}">
                            <i class="fas fa-cash-register"></i><span>Fees Summary</span></a>
                    </li>
                @endif

                @if ($role != 'student' && $role != 'master')
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="flaticon-multiple-users-silhouette"></i><span>Teachers</span></a>
                        <ul class="nav sub-group-menu {{ $teacher == 1 ? 'sub-group-active' : ''}}">
                            @if($role == 'admin')
                                <li class="nav-item">
                                    <a href="{{ route('new.teacher') }}"
                                       class="nav-link {{ (request()->routeIs('new.teacher')) ? 'menu-active' : '' }}">
                                        <i class="fas fa-angle-right"></i><span>Add Teacher</span></a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{url('users/' .Auth::user()->school->code. '/0/1?teacher=1')}}"
                                   class="nav-link {{ Request::get('teacher') == 1 ? 'menu-active' :''}}">
                                    <i class="fas fa-angle-right"></i><span>All Teachers</span></a>
                            </li>
                            @if($role == 'admin')
                                <li class="nav-item sidebar-nav-item second-lbl-menu">
                                    <a href="#" class="nav-link "> <i class="fas fa-angle-right"></i><span>Shift</span></a>
                                    <ul class="nav sub-group-menu {{ $acc == 1 ? 'sub-group-active' : '' }}">
                                        <li class="nav-item">
                                            <a class="nav-link {{ (request()->is('shift.create')) ? 'menu-active' : '' }}"
                                            href="{{ route('shift.create') }}">
                                            <i class="fas fa-angle-right"></i><span>Add Shift</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ (request()->is('shifts')) ? 'menu-active' : '' }}"
                                            href="{{ route('shifts') }}">
                                                <i class="fas fa-angle-right"></i><span> All Shifts</span></a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </li>
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="flaticon-classmates"></i><span>Students</span></a>
                        <ul class="nav sub-group-menu {{ $std == 1 ? 'sub-group-active' : '' }}">
                            @if($role == 'admin')
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->is('admin/new-student')) ? 'menu-active' : '' }}"
                                       href="{{ url('admin/new-student') }}">
                                        <i class="fas fa-angle-right"></i><span>Add Student</span></a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link {{ Request::get('student') == 1 ? 'menu-active' : '' }}"
                                   href="{{ url('users/' .Auth::user()->school->code. '/1/0?student=1') }}">
                                    <i class="fas fa-angle-right"></i> <span>All Students</span></a>
                            </li>
                            @if($role == 'admin')
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->is('admin/student-message')) ? 'menu-active' : '' }}"
                                       href="{{ url('admin/student-message') }}">
                                        <i class="fas fa-angle-right"></i><span>Message Student</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->is('admin/import-student')) ? 'menu-active' : '' }}"
                                       href="{{ url('admin/import-student') }}">
                                        <i class="fas fa-angle-right"></i><span>Import Student</span></a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if ($role == 'admin')
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fa fa-building"></i><span>Department</span></a>
                        <ul class="nav sub-group-menu {{ $department == 1 ? 'sub-group-active' : ''}}">
                            <li class="nav-item">
                                <a href="{{ route('create.department') }}"
                                   class="nav-link {{ (request()->routeIs('create.department')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>Add Department</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('all.department') }}"
                                   class="nav-link {{ (request()->routeIs('all.department')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>All Department</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fab fa-readme"></i><span>Class Management</span></a>
                        <ul class="nav sub-group-menu {{ $class == 1 ? 'sub-group-active' : ''}}">
                            <li class="nav-item">
                                <a href="{{ route('school.section','course=1') }}"
                                   class="nav-link {{ Request::get('course') == 1 ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>Class Details</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('manage.class') }}"
                                   class="nav-link {{ (request()->routeIs('manage.class')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>Manage Classes</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('academic.routines') }}"
                                   class="nav-link {{ (request()->routeIs('academic.routines')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>Class Routine</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-sliders-h"></i><span>Academic</span></a></a>
                        <ul class="nav sub-group-menu {{ $academic == 1 ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a href="{{ route('grades.classes') }}"
                                   class="nav-link {{ (request()->routeIs('grades.classes')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>Grades</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('academic.syllabus') }}"
                                   class="nav-link {{ (request()->routeIs('academic.syllabus')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>Syllabus</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('academic.notice') }}"
                                   class="nav-link {{ (request()->routeIs('academic.notice')) ? 'menu-active' : '' }}
                                       && {{ (request()->routeIs('create.notice')) ? 'menu-active' : '' }}
                                       && {{ (request()->routeIs('show.notice')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>Notice</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('academic.event') }}"
                                   class="nav-link {{ (request()->routeIs('academic.event')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>Events</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('create.admit') }}"
                                   class="nav-link {{ (request()->routeIs('create.admit')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>Admit Card</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-poll-h"></i><span>Manage GPA</span></a>
                        <ul class="nav sub-group-menu {{ $gpa == 1 ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('admin/gpa/create-gpa')) ? 'menu-active' : '' }}"
                                   href="{{ url('admin/gpa/create-gpa') }}"><i class="fas fa-angle-right"></i><span>Add New Grade System</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('admin/gpa/all-gpa')) ? 'menu-active' : '' }}"
                                   href="{{ url('admin/gpa/all-gpa') }}"><i
                                        class="fas fa-angle-right"></i><span>All GPA</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-file-alt"></i><span>Exams</span></a>
                        <ul class="nav sub-group-menu {{ $ex == 1 ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->routeIs('exams.create')) ? 'menu-active' : '' }}"
                                   href="{{ route('exams.create') }}"><i class="fas fa-angle-right"></i><span>Add Examination</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->routeIs('exams.active')) ? 'menu-active' : '' }}"
                                   href="{{ route('exams.active') }}"><i class="fas fa-angle-right"></i><span>Active Exams</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->routeIs('exams')) ? 'menu-active' : '' }}"
                                   href="{{ route('exams') }}"><i class="fas fa-angle-right"></i><span>Manage Examinations</span></a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if ($role == 'teacher')
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('teacher/courses/'.Auth::user()->id.'/0')) ? 'menu-active' : '' }}"
                           href="{{ url('teacher/courses/'.Auth::user()->id.'/0') }}">
                            <i class="fas fa-book-medical"></i><span>My Courses</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('teacher/attendance/'.Auth::user()->id)) ? 'menu-active' : '' }}"
                           href="{{ url('teacher/attendance/'.Auth::user()->id) }}">
                            <i class="far fa-calendar-check"></i><span>My Attendance</span></a>
                    </li>
                @endif
                @if ($role == 'admin' || $role == 'accountant')

{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ url($role.'/fees/all') }}"--}}
{{--                           class="nav-link {{ (request()->is($role.'/fees/all')) ? 'menu-active' : '' }}">--}}
{{--                            <i class="fas fa-hand-holding-usd"></i><span>Fees Generators</span></a>--}}
{{--                    </li>--}}
                    @if ($role == 'accountant')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('accountant/attendance/'.Auth::user()->id)) ? 'menu-active' : '' }}"
                               href="{{ url('accountant/attendance/'.Auth::user()->id) }}">
                                <i class="far fa-calendar-check"></i><span>My Attendance</span></a>
                        </li>
                    @endif

                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i
                                    class="fas fa-file-invoice-dollar"></i><span>Manage Accounts</span></a>
                        <ul class="nav sub-group-menu {{ $acc == 1 ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->routeIs('new.accountant')) ? 'menu-active' : '' }}"
                                   href="{{ route('new.accountant') }}">
                                    <i class="fas fa-angle-right"></i><span>Add accountant</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ ($acc == 1 && $all_student == 1 ) ? 'menu-active' : '' }}"
                                   href="{{url($role.'/users/' .Auth::user()->school->code. '/accountant')}}">
                                    <i class="fas fa-angle-right"></i><span>Accountant List</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is($role.'/sectors')) ? 'menu-active' : '' }}"
                                   href="{{ url($role.'/sectors') }}">
                                    <i class="fas fa-angle-right"></i><span>Add Account Sector</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is($role.'/expense')) ? 'menu-active' : '' }}"
                                   href="{{ url($role.'/expense') }}">
                                    <i class="fas fa-angle-right"></i><span>Add New Expense</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is($role.'/expense-list')) ? 'menu-active' : '' }}"
                                   href="{{ url($role.'/expense-list') }}">
                                    <i class="fas fa-angle-right"></i><span>Expense List</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is($role.'/income')) ? 'menu-active' : '' }}"
                                   href="{{ url($role.'/income') }}">
                                    <i class="fas fa-angle-right"></i><span>Add New Income</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is($role.'/income-list')) ? 'menu-active' : '' }}"
                                   href="{{ url($role.'/income-list') }}">
                                    <i class="fas fa-angle-right"></i><span>Income List</span></a>
                            </li>
                            <li class="nav-item sidebar-nav-item second-lbl-menu">
                                <a href="#" class="nav-link "> <i class="fas fa-angle-right"></i><span>Fee Collection</span></a>
                                <ul class="nav sub-group-menu {{ $acc == 1 ? 'sub-group-active' : '' }}">
                                    <li class="nav-item">
                                        <a class="nav-link {{ (request()->is($role.'/fee-types*')) ? 'menu-active' : '' }}"
                                        href="{{ url($role.'/fee-types') }}">
                                        <i class="fas fa-angle-right"></i><span>Fee Types</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ (request()->is($role.'/fee-master*')) ? 'menu-active' : '' }}"
                                        href="{{ url($role.'/fee-master') }}">
                                            <i class="fas fa-angle-right"></i><span>Fee Master</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ (request()->is($role.'/fee-discount*')) ? 'menu-active' : '' }}"
                                        href="{{ url($role.'/fee-discount') }}">
                                            <i class="fas fa-angle-right"></i><span>Discount</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ (request()->is($role.'/fee-collection*')) ? 'menu-active' : '' }}"
                                        href="{{ url($role.'/fee-collection/section/student') }}">
                                            <i class="fas fa-angle-right"></i><span>Collect Fee</span></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        
                    </li>
                @endif

                @if ($role == 'admin' || $role == 'librarian')
                    @if ($role == 'librarian')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('librarian/attendance/'.Auth::user()->id)) ? 'menu-active' : '' }}"
                               href="{{ url('librarian/attendance/'.Auth::user()->id) }}">
                                <i class="far fa-calendar-check"></i><span>My Attendance</span></a>
                        </li>
                    @endif
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-book-open"></i><span>Manage Library</span></a>
                        <ul class="nav sub-group-menu menu-open {{ $lib==1 ? 'sub-group-active' : '' }}"
                            style="display: block;">
                            <li class="nav-item">
                                <a href="{{ url('admin/new-librarian') }}"
                                   class="nav-link {{ (request()->is('admin/new-librarian')) ? 'menu-active' : '' }}"><i
                                        class="fas fa-angle-right"></i>Add Librarian</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url($role.'/users/'.Auth::user()->school->code.'/librarian') }}"
                                   class="nav-link {{ (request()->is($role.'/users/' .Auth::user()->school->code. '/librarian')) ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>Librarian List</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url($role.'/all-books') }}"
                                   class="nav-link {{ (request()->is($role.'/all-books')) ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>All Books</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url($role.'/issued-books') }}"
                                   class="nav-link {{ (request()->is($role.'/issued-books')) ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>All Issued Books</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url($role.'/issue-books') }}"
                                   class="nav-link {{ (request()->is($role.'/issue-books')) ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>Issue Book</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url($role.'/create/book') }}"
                                   class="nav-link {{ (request()->is($role.'/create/book')) ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>Add Book</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
@endif
