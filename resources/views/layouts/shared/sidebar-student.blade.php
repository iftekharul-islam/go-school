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
                         <a href="{{ url('home') }}" class="nav-link"><i class="flaticon-dashboard"></i><span>Dashboard</span></a>
                     </li>
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
                     @if(Auth::user()->role != 'student')
                         <li class="nav-item">
                             <a class="nav-link" href="{{url('users/'.Auth::user()->school->code.'/1/0')}}">
                                 <i class="flaticon-classmates"></i> <span>Students</span></a>
                         </li>
                         <li class="nav-item">
                             <a class="nav-link" href="{{url('users/'.Auth::user()->school->code.'/0/1')}}">
                                 <i class="flaticon-multiple-users-silhouette"></i><span>Teachers</span></a>
                         </li>
                     @endif
                     @if(Auth::user()->role == 'teacher')
                         <li class="nav-item">
                             <a class="nav-link" href="{{ url('courses/'.Auth::user()->id.'/0') }}"><i class="flaticon-open-book"></i>
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
                 </ul>
             </div>
     </div>
    @endif