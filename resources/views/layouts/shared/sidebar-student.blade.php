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
            $sht = 0;
            $att = 0;
            $staff = 0;
            $fee_collection = 0;
            if (strpos($add, 'teacher-attendance') || strpos($add, 'all-staff') || strpos($add, 'attendance') || Request::get('course') == 2 || strpos($add, 'attendance-time') || strpos($add, 'all-teachers'))
                $att = 1;
            if (strpos($add, 'book') || strpos($add, 'librarian') || strpos($add, 'new-librarian'))
                $lib = 1;
            if (strpos($add, 'exams'))
                $ex = 1;
            if (strpos($add, 'gpa'))
                $gpa = 1;
            if (strpos($add, 'sectors') || strpos($add, 'expense') || strpos($add, 'income') ||  strpos($add, 'accountant') || strpos($add, 'fee-types') || strpos($add, 'fee-collection') || strpos($add, 'fee-discount') || strpos($add, 'fee-master') || strpos($add, 'advance-collection'))
                $acc = 1;
            if (strpos($add, 'fee-types') || strpos($add, 'fee-discount') || strpos($add, 'fee-master') || strpos($add, 'fee-collection') || strpos($add, 'fees-summary'))
                $ac = 1;
            if (( strpos($add, 'users/') &&  Request::get('student') == 1 )   || strpos($add, 'student-message') || strpos($add, 'new-student') || strpos($add, 'import-student') || strpos($add, 'my-students'))
                $std = 1;
            if (strpos($add, 'users/'))
                $all_student = 1;
            if ((strpos($add, 'users/') && Request::get('teacher'))  || strpos($add,'new-teacher') || strpos($add,'shifts') || strpos($add,'shift'))
                $teacher = 1;
            if (strpos($add,'all-department')  || strpos($add,'create-department'))
                $department = 1;
            if (strpos($add,'routine')  || Request::get('course') == 1 || strpos($add,'manage-class'))
                $class = 1;
            if (strpos($add, 'classes')  || (strpos($add, 'syllabus')) || strpos($add, 'notice') || (strpos($add, 'event')) || (strpos($add, 'create-admit-card')) || (strpos($add, 'messages')))
                $academic = 1;
            if (strpos($add, 'shift')  || (strpos($add, 'shifts')) )
                $sht = 1;
             if (strpos($add, 'new-staff') || strpos($add, 'Staff-list'))
                $staff = 1;
             if (strpos($add, 'fee-types') || strpos($add, 'fee-collection') || strpos($add, 'fee-discount') || strpos($add, 'fee-master') || strpos($add, 'advance-collection'))
                $fee_collection = 1;
        @endphp
        <div class="sidebar-menu-content">
            <ul class="nav nav-sidebar-menu sidebar-toggle-view">
                <li class="nav-item">
                    <a href="{{ url($role.'/home') }}" class="nav-link "><i
                            class="flaticon-dashboard"></i><span>{{ __('text.Dashboard') }}</span></a>
                </li>

                @if ($role == 'master')
                    <?php
                    $schools = \App\School::all();
                    ?>
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-school"></i><span>{{ __('text.schools') }}</span></a>
                        <ul class="nav sub-group-menu {{ (request()->is('master/new*')) ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a href="{{url('master/new/create-school')}}"
                                   class="nav-link {{ (request()->is('master/new/create-school')) ? 'menu-active' : '' }}"><i
                                        class="fas fa-angle-right"></i>{{ __('text.create_school') }}</a>
                                <a href="{{url('master/new/all-school')}}"
                                   class="nav-link {{ (request()->is('master/new/all-school')) ? 'menu-active' : '' }}"><i
                                        class="fas fa-angle-right"></i>{{ __('text.all_school') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item sidebar-nav-item">
                        <a href="{{route('generate.invoice')}}"
                           class="nav-link {{ (request()->is('master/generate-invoice')) ? 'menu-active' : '' }}"><i
                                class="fas fa-file-invoice"></i><span>{{ __('text.invoice') }}</span></a>
                    </li>
                    <li class="nav-item sidebar-nav-item">
                        <a href="{{route('super.user.list')}}"
                           class="nav-link {{ (request()->routeIs('super.user.list')) ? 'menu-active' : '' }}"><i
                                class="fas fa-money-check-alt"></i><span>{{ __('text.staff_list') }}</span></a>
                    </li>
                    <li class="nav-item sidebar-nav-item">
                        <a href="{{route('default.fee.types')}}"
                           class="nav-link {{ (request()->is('master/default/fee-types')) ? 'menu-active' : '' }}"><i
                                class="fas fa-money-check-alt"></i><span>{{ __('text.default_fee_types') }}</span></a>
                    </li>
                @endif

                @if ($role == 'admin')
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i
                                class="fas fa-user-plus"></i><span>{{ __('text.Attendance') }}</span></a>
                        <ul class="nav sub-group-menu {{ ($att == 1) ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a href="{{ url('admin/staff/all-teachers') }}"
                                   class="nav-link {{ (request()->is('admin/staff/all-teachers')) ? 'menu-active' : '' }}"><i
                                        class="fas fa-angle-right"></i>{{ __('text.Teachers Attendance') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('all.staff') }}"
                                   class="nav-link {{ (request()->routeIs('staff.attendance')) || (request()->routeIs('all.staff')) ? 'menu-active' : '' }}"><i
                                        class="fas fa-angle-right"></i>{{ __('text.Staff Attendance') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::get('course') == 2  ? 'menu-active' : '' }}"
                                   href="{{ url('admin/school/sections?course=2') }}"><i
                                        class="fas fa-angle-right"></i>{{ __('text.Students Attendance') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('admin/attendance-time')) ? 'menu-active' : '' }}"
                                   href="{{ route('configure.attendance.time') }}"><i
                                        class="fas fa-angle-right"></i>{{ __('text.Configuration') }}</a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if ($role == 'student')
                    <li class="nav-item">
                        <a href="{{ url('student/attendances/0/' . Auth::user()->id . '/0') }}" class="nav-link">
                            <i class="far fa-calendar-check"></i><span>{{ __('text.my_attendance') }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('student/courses/0/'.Auth::user()->section_id) }}"
                           class="nav-link {{ (request()->is('student/courses/0/'.Auth::user()->section_id)) ? 'menu-active' : '' }}">
                            <i class="fas fa-book-open"></i><span>{{ __('text.my_course') }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('student/grades/'.Auth::user()->id) }}"
                           class="nav-link {{ (request()->is('student/grades/'.Auth::user()->id)) ? 'menu-active' : '' }}">
                            <i class="fas fa-poll"></i><span>{{ __('text.my_grade') }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('student/user/notifications/'.\Auth::user()->id) }}"
                           class="nav-link {{ (request()->is('student/user/notifications/'.\Auth::user()->id)) ? 'menu-active' : '' }}">
                            <i class="fas fa-envelope-open"></i><span>{{ __('text.message') }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $ac == 1 ? 'menu-active' : '' }}"
                           href="{{ route('fees.summary') }}">
                            <i class="fas fa-cash-register"></i><span>{{ __('text.fees_summary') }}</span></a>
                    </li>
                @endif
                @if(in_array($role, ['student', 'teacher', 'accountant', 'librarian']))
                    <li class="nav-item">
                        <a href="{{ url('notices-and-events') }}"
                           class="nav-link {{ (request()->is('notices-and-events')) ? 'menu-active' : '' }}"><i
                                class="fas fa-exclamation-circle"></i><span>{{ __('text.event_notice') }}</span></a>
                    </li>
                @endif

                @if ($role != 'student' && $role != 'master')
                    <li class="nav-item sidebar-nav-item">
                        @if($role == 'admin')
                            <a href="#" class="nav-link"><i
                                    class="flaticon-multiple-users-silhouette"></i><span>{{ __('text.Teachers') }}</span></a>
                            <ul class="nav sub-group-menu {{ $teacher == 1 ? 'sub-group-active' : ''}}">

                                <li class="nav-item">
                                    <a href="{{ route('new.teacher') }}"
                                       class="nav-link {{ (request()->routeIs('new.teacher')) ? 'menu-active' : '' }}">
                                        <i class="fas fa-angle-right"></i><span>{{ __('text.Add Teacher') }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{url('users/' .Auth::user()->school->code. '/0/1?teacher=1')}}"
                                       class="nav-link {{ Request::get('teacher') == 1 ? 'menu-active' :''}}">
                                        <i class="fas fa-angle-right"></i><span>{{ __('text.All Teacher') }}</span></a>
                                </li>
                                <li class="nav-item sidebar-nav-item second-lbl-menu {{ $sht == 1 ? 'active' : ''}}">
                                    <a href="#" class="nav-link "> <i
                                            class="fas fa-angle-right"></i><span>{{ __('text.Shift') }}</span></a>
                                    <ul class="nav sub-group-menu {{ $sht == 1 ? 'sub-group-active' : '' }}">
                                        <li class="nav-item">
                                            <a class="nav-link {{ (request()->is('admin/shift/create')) ? 'menu-active' : '' }}"
                                               href="{{ route('shift.create') }}">
                                                <i class="fas fa-angle-right"></i><span>{{ __('text.add_shift') }}</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ (request()->is('admin/shifts')) ? 'menu-active' : '' }}"
                                               href="{{ route('shifts') }}">
                                                <i class="fas fa-angle-right"></i><span>{{ __('text.all_shifts') }}</span></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        @endif
                    </li>
                    @if(\Auth::user()->role == 'teacher')
                        <li class="nav-item">
                            <a class="nav-link {{ (request()->is('teacher/my-students')) == 1 ? 'menu-active' : '' }}"
                               href="{{ route('student.list') }}">
                                <i class="flaticon-classmates"></i> <span>{{ __('text.my_students') }}</span></a>
                        </li>
                    @endif
                    @if($role == 'admin')
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i
                                    class="flaticon-classmates"></i><span>{{ __('text.Students') }}</span></a>
                            <ul class="nav sub-group-menu {{ $std == 1 ? 'sub-group-active' : '' }}">
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->is('admin/new-student')) ? 'menu-active' : '' }}"
                                       href="{{ url('admin/new-student') }}">
                                        <i class="fas fa-angle-right"></i><span>{{ __('text.Add Student') }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ Request::get('student') == 1 ? 'menu-active' : '' }}"
                                       href="{{ url('users/' .Auth::user()->school->code. '/1/0?student=1') }}">
                                        <i class="fas fa-angle-right"></i>
                                        <span>{{ __('text.All Students') }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->is('admin/student-message')) ? 'menu-active' : '' }}"
                                       href="{{ url('admin/student-message') }}">
                                        <i class="fas fa-angle-right"></i><span>{{ __('text.Message Student') }}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->is('admin/import-student')) ? 'menu-active' : '' }}"
                                       href="{{ url('admin/import-student') }}">
                                        <i class="fas fa-angle-right"></i><span>{{ __('text.Import Student') }} (By Excel)</span></a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif

                @if ($role == 'admin')
                    <li class="nav-item sidebar-nav-item">
                        <a class="nav-link {{ (request()->routeIs('all.guardian')) || (request()->routeIs('create.guardian')) ? 'menu-active' : '' }}"
                           href="{{ route('all.guardian') }}">
                            <i class="far fa-question-circle">
                            </i><span>{{ __('text.guardians') }}</span>
                        </a>
                    </li>
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i
                                class="fa fa-building"></i><span>{{__('text.Department')}}</span></a>
                        <ul class="nav sub-group-menu {{ $department == 1 ? 'sub-group-active' : ''}}">
                            <li class="nav-item">
                                <a href="{{ route('create.department') }}"
                                   class="nav-link {{ (request()->routeIs('create.department')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>{{ __('text.Add Department') }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('all.department') }}"
                                   class="nav-link {{ (request()->routeIs('all.department')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>{{ __('text.All Department') }}</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i
                                class="fab fa-readme"></i><span>{{ __('text.Class Management') }}</span></a>
                        <ul class="nav sub-group-menu {{ $class == 1 ? 'sub-group-active' : ''}}">
                            <li class="nav-item">
                                <a href="{{ route('school.section','course=1') }}"
                                   class="nav-link {{ Request::get('course') == 1 ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>{{ __('text.all_classes') }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('manage.class') }}"
                                   class="nav-link {{ (request()->routeIs('manage.class')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>{{ __('text.Manage Classes') }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('academic.routines') }}"
                                   class="nav-link {{ (request()->routeIs('academic.routines')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>{{ __('text.Class Routine') }}</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i
                                class="fas fa-sliders-h"></i><span>{{ __('text.Academic') }}</span></a></a>
                        <ul class="nav sub-group-menu {{ $academic == 1 ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a href="{{ route('grades.classes') }}"
                                   class="nav-link {{ (request()->routeIs('grades.classes')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>{{ __('text.Grades') }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('academic.syllabus') }}"
                                   class="nav-link {{ (request()->routeIs('academic.syllabus')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>{{ __('text.Syllabus') }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('academic.notice') }}"
                                   class="nav-link {{ (request()->routeIs('academic.notice')) ? 'menu-active' : '' }}
                                       && {{ (request()->routeIs('create.notice')) ? 'menu-active' : '' }}
                                       && {{ (request()->routeIs('show.notice')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>{{ __('text.Notice') }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('academic.event') }}"
                                   class="nav-link {{ (request()->routeIs('academic.event')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>{{ __('text.Events') }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('all.messages') }}"
                                   class="nav-link {{ (request()->routeIs('all.messages')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>{{ __('text.message') }}</span></a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ route('create.admit') }}"
                                   class="nav-link {{ (request()->routeIs('create.admit')) ? 'menu-active' : '' }}">
                                    <i class="fas fa-angle-right"></i><span>{{ __('text.Admit Card') }}</span></a>
                            </li> --}}
                        </ul>
                    </li>
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i
                                class="fas fa-poll-h"></i><span>{{ __('text.Manage GPA') }}</span></a>
                        <ul class="nav sub-group-menu {{ $gpa == 1 ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('admin/gpa/create-gpa')) ? 'menu-active' : '' }}"
                                   href="{{ url('admin/gpa/create-gpa') }}"><i
                                        class="fas fa-angle-right"></i><span>{{ __('text.Add New Grade System') }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is('admin/gpa/all-gpa')) ? 'menu-active' : '' }}"
                                   href="{{ url('admin/gpa/all-gpa') }}"><i
                                        class="fas fa-angle-right"></i><span>{{ __('text.All GPA') }}</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-file-alt"></i><span>{{ __('text.Exams') }}</span></a>
                        <ul class="nav sub-group-menu {{ $ex == 1 ? 'sub-group-active' : '' }}">
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->routeIs('exams.create')) ? 'menu-active' : '' }}"
                                   href="{{ route('exams.create') }}"><i
                                        class="fas fa-angle-right"></i><span>{{ __('text.Add Examination') }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->routeIs('exams.active')) ? 'menu-active' : '' }}"
                                   href="{{ route('exams.active') }}"><i
                                        class="fas fa-angle-right"></i><span>{{ __('text.Active Exams') }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->routeIs('exams')) ? 'menu-active' : '' }}"
                                   href="{{ route('exams') }}"><i
                                        class="fas fa-angle-right"></i><span>{{ __('text.Manage Examinations') }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->routeIs('exams.results')) ? 'menu-active' : '' }}"
                                   href="{{ route('exams.results') }}"><i
                                        class="fas fa-angle-right"></i><span>{{ __('text.result') }}</span></a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if ($role == 'teacher')
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->routeIs('my.messages' , Auth::user()->id)) ? 'menu-active' : '' }}"
                           href="{{ route('my.messages' , Auth::user()->id) }}">
                            <i class="fas fa-envelope"></i><span>{{ __('text.my_messages') }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('teacher/courses/'.Auth::user()->id.'/0')) ? 'menu-active' : '' }}"
                           href="{{ url('teacher/courses/'.Auth::user()->id.'/0') }}">
                            <i class="fas fa-book-medical"></i><span>{{ __('text.my_course') }}</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('teacher/attendance/'.Auth::user()->id)) ? 'menu-active' : '' }}"
                           href="{{ url('teacher/attendance/'.Auth::user()->id) }}">
                            <i class="far fa-calendar-check"></i><span>{{ __('text.my_attendance') }}</span></a>
                    </li>
                @endif

                @if ($role == 'teacher' || $role == 'student')
                    <li class="nav-item">
                        <a href="{{ route('syllabus') }}"
                           class="nav-link {{ (request()->routeIs('syllabus')) ? 'menu-active' : '' }}">
                            <i class="fas fa-list"></i><span>{{ __('text.Syllabus') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="@if($role == 'teacher') {{ route('routines') }} @else {{ route('class.routines') }} @endif"
                           class="nav-link {{ (request()->routeIs('routines')) ? 'menu-active' : '' }}">
                            <i class="fas fa-calendar"></i><span>{{ __('text.Class Routine') }}</span>
                        </a>
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
                                <i class="far fa-calendar-check"></i><span>{{ __('text.my_attendance') }}</span></a>
                        </li>
                    @endif

                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i
                                class="fas fa-file-invoice-dollar"></i><span>{{ __('text.Manage Accounts') }}</span></a>
                        <ul class="nav sub-group-menu {{ $acc == 1 ? 'sub-group-active' : '' }}">
                            @if ($role == 'admin')
                                <li class="nav-item">
                                    <a class="nav-link {{ (request()->routeIs('new.accountant')) ? 'menu-active' : '' }}"
                                       href="{{ route('new.accountant') }}">
                                        <i class="fas fa-angle-right"></i><span>{{ __('text.Add accountant') }}</span></a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link {{ ($acc == 1 && $all_student == 1 ) ? 'menu-active' : '' }}"
                                   href="{{url($role.'/users/' .Auth::user()->school->code. '/accountant')}}">
                                    <i class="fas fa-angle-right"></i><span>{{ __('text.Accountant List') }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is($role.'/sectors')) ? 'menu-active' : '' }}"
                                   href="{{ url($role.'/sectors') }}">
                                    <i class="fas fa-angle-right"></i><span>{{ __('text.Add Account Sector') }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is($role.'/expense')) ? 'menu-active' : '' }}"
                                   href="{{ url($role.'/expense') }}">
                                    <i class="fas fa-angle-right"></i><span>{{ __('text.add_expense') }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is($role.'/expense-list')) ? 'menu-active' : '' }}"
                                   href="{{ url($role.'/expense-list') }}">
                                    <i class="fas fa-angle-right"></i><span>{{ __('text.Expense List') }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is($role.'/income')) ? 'menu-active' : '' }}"
                                   href="{{ url($role.'/income') }}">
                                    <i class="fas fa-angle-right"></i><span>{{ __('text.Add New Income') }}</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (request()->is($role.'/income-list')) ? 'menu-active' : '' }}"
                                   href="{{ url($role.'/income-list') }}">
                                    <i class="fas fa-angle-right"></i><span>{{ __('text.Income List') }}</span></a>
                            </li>
                            <li class="nav-item sidebar-nav-item second-lbl-menu">
                                <a href="#" class="nav-link "> <i
                                        class="fas fa-angle-right"></i><span>{{ __('text.Fee Collection') }}</span></a>
                                <ul class="nav sub-group-menu {{ $fee_collection == 1 ? 'sub-group-active' : '' }}">
                                    <li class="nav-item">
                                        <a class="nav-link {{ (request()->is($role.'/fee-types*')) ? 'menu-active' : '' }}"
                                           href="{{ url($role.'/fee-types') }}">
                                            <i class="fas fa-angle-right"></i><span>{{ __('text.Fee Types') }}</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ (request()->is($role.'/fee-discount*')) ? 'menu-active' : '' }}"
                                           href="{{ url($role.'/fee-discount') }}">
                                            <i class="fas fa-angle-right"></i><span>{{ __('text.Discount') }}</span></a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link {{ (request()->is($role.'/advance-collection')) ? 'menu-active' : '' }}"
                                           href="{{ url($role.'/advance-collection') }}">
                                            <i class="fas fa-angle-right"></i><span>{{ __('text.advance_collection') }}</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ (request()->is($role.'/fee-collection*')) ? 'menu-active' : '' }}"
                                           href="{{ url($role.'/fee-collection/section/student') }}">
                                            <i class="fas fa-angle-right"></i><span>{{ __('text.Collect Fee') }}</span></a>
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
                                <i class="far fa-calendar-check"></i><span>{{ __('text.my_attendance') }}</span></a>
                        </li>
                    @endif
                    <li class="nav-item sidebar-nav-item">
                        <a href="#" class="nav-link"><i
                                class="fas fa-book-open"></i><span>{{ __('text.Manage Library') }}</span></a>
                        <ul class="nav sub-group-menu menu-open {{ $lib==1 ? 'sub-group-active' : '' }}"
                            style="display: block;">
                            @if ($role == 'admin')
                                <li class="nav-item">
                                    <a href="{{ url('admin/new-librarian') }}"
                                       class="nav-link {{ (request()->is('admin/new-librarian')) ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>{{ __('text.Add Librarian') }}</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ url($role.'/users/'.Auth::user()->school->code.'/librarian') }}"
                                   class="nav-link {{ (request()->is($role.'/users/' .Auth::user()->school->code. '/librarian')) ? 'menu-active' : '' }}"><i
                                        class="fas fa-angle-right"></i>{{ __('text.Librarian List') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url($role.'/all-books') }}"
                                   class="nav-link {{ (request()->is($role.'/all-books')) ? 'menu-active' : '' }}"><i
                                        class="fas fa-angle-right"></i>{{ __('text.All Books') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url($role.'/issued-books') }}"
                                   class="nav-link {{ (request()->is($role.'/issued-books')) ? 'menu-active' : '' }}"><i
                                        class="fas fa-angle-right"></i>{{ __('text.All Issued Books') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url($role.'/issue-books') }}"
                                   class="nav-link {{ (request()->is($role.'/issue-books')) ? 'menu-active' : '' }}"><i
                                        class="fas fa-angle-right"></i>{{ __('text.Issue Book') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url($role.'/returned-books') }}"
                                   class="nav-link {{ (request()->is($role.'/returned-books')) ? 'menu-active' : '' }}"><i
                                        class="fas fa-angle-right"></i>{{ __('text.returned_books') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url($role.'/create/book') }}"
                                   class="nav-link {{ (request()->is($role.'/create/book')) ? 'menu-active' : '' }}"><i
                                        class="fas fa-angle-right"></i>{{ __('text.Add Book') }}</a>
                            </li>
                        </ul>
                    </li>
                    @if ($role == 'admin')
                        <li class="nav-item sidebar-nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-users"></i>
                                </i><span>{{ __('text.staff_management') }}</span>
                            </a>
                            <ul class="nav sub-group-menu {{ ($staff == 1) ? 'sub-group-active' : '' }}">
                                <li class="nav-item">
                                    <a href="{{ route('new.staff') }}"
                                       class="nav-link {{ (request()->routeIs('new.staff')) ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>{{ __('text.add_staff') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('staff.list') }}"
                                       class="nav-link {{ (request()->is('admin/Staff-list')) ? 'menu-active' : '' }}"><i
                                            class="fas fa-angle-right"></i>{{ __('text.staff_list') }}</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.sms.summary' ,auth::user()->school_id) }}"
                               class="nav-link {{ (request()->routeIs('admin.sms.summary' ,auth::user()->school_id)) ? 'menu-active' : '' }}">
                                <i class="fas fa-book-open"></i><span>{{ __('text.sms_history') }}</span></a>
                        </li>
                    @endif
                @endif
                @if ($role == 'admin' || $role == 'teacher')
                    <li class="nav-item sidebar-nav-item">
                        <a class="nav-link {{ (request()->routeIs('class.schedule')) || (request()->routeIs('class.schedule.create')) ? 'menu-active' : '' }}"
                           href="{{ route('class.schedule') }}">
                            <i class="fas fa-globe"></i>
                            </i><span>{{ __('text.online_class_schedule') }}</span>
                        </a>
                    </li>
                @endif
                @if ($role == 'guardian')
                    <li class="nav-item sidebar-nav-item">
                        <a class="nav-link {{ (request()->routeIs('child')) ? 'menu-active' : '' }}"
                           href="{{ route('child') }}">
                            <i class="fas fa-child"></i>
                            </i><span>{{ __('text.my_child') }}</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item sidebar-nav-item">
                    <a class="nav-link" href="#">
                        <i class="far fa-question-circle">
                        </i><span>{{ __('text.help') }}</span>
                    </a>
                    <ul class="nav sub-group-menu">
                        <li class="nav-item">
                            <a class="nav-link"
                               href="{{ url('https://www.youtube.com/channel/UCN8SOrFD4WvHftsrpfn1jyw?view_as=subscriber') }}"
                               target="_blank">
                                <i class="fas fa-angle-right"></i>
                                <span>{{ __('text.online_training') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               href="{{ url('https://drive.google.com/drive/folders/1sMq3BY7R5aUhzJ1DfM8-_6if0vTIIC8o') }}"
                               target="_blank">
                                <i class="fas fa-angle-right"></i>
                                <span>{{ __('text.user_manual') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
@endif
