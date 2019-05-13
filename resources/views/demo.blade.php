shubhra@augnitive.com -> admin
schiller.frida@example.com -> student
stark.tyrique@example.org -> teacher
cboyer@example.net -> accountant
hcrona@example.com -> librarian



 <nav class="navbar navbar-default navbar-static-top">
    <div class="container" style="display: block !important;">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse"
                    aria-expanded="false">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/home') }}" style="color: #000;">
                {{ (Auth::check() && (Auth::user()->role == 'student' || Auth::user()->role == 'teacher' ||
                Auth::user()->role == 'admin' || Auth::user()->role == 'accountant' || Auth::user()->role ==
                'librarian'))?Auth::user()->school->name:'Laravel' }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}" style="color: #000;">Login</a></li>
                @else
                    @if(\Auth::user()->role == 'student')
                        <li class="nav-item">
                            <a href="{{url('user/'.\Auth::user()->id.'/notifications')}}" class="nav-link nav-link-align-btn"
                               role="button">
                                <?php
                                $mc = \App\Notification::where('student_id',\Auth::user()->id)->where('active',1)->count();
                                ?>
                                @if($mc > 0)
                                    <span class="label label-danger" style="vertical-align: middle;border-style: none;border-radius: 50%;width: 30px;height: 30px;">{{$mc}}</span>
                                @endif
                            </a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle nav-link-align-btn" data-toggle="dropdown" role="button"
                           aria-expanded="false" aria-haspopup="true">
                                <span class="label label-danger">
                                    {{ ucfirst(\Auth::user()->role) }}
                                </span>&nbsp;&nbsp;
                            @if(!empty(Auth::user()->pic_path))
                                <img src="{{asset('01-progress.gif')}}" data-src="{{url(Auth::user()->pic_path)}}" alt="Profile Picture"
                                     style="vertical-align: middle;border-style: none;border-radius: 50%;width: 30px;height: 30px;">
                            @else
                                @if(strtolower(Auth::user()->gender) == 'male')
                                    <img src="{{asset('01-progress.gif')}}" data-src="https://png.icons8.com/dusk/200/000000/user.png"
                                         alt="Profile Picture" style="vertical-align: middle;border-style: none;border-radius: 50%;width: 30px;height: 30px;">
                                @else
                                    <img src="{{asset('01-progress.gif')}}" data-src="https://png.icons8.com/dusk/200/000000/user-female.png"
                                         alt="Profile Picture" style="vertical-align: middle;border-style: none;border-radius: 50%;width: 30px;height: 30px;">
                                @endif
                            @endif
                            &nbsp;&nbsp;{{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu">
                            @if(Auth::user()->role != 'master')
                                <li>
                                    <a href="{{url('user/'.Auth::user()->student_code)}}">Profile</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{url('user/config/change_password')}}">Change Password</a>
                            </li>
                            @if(env('APP_ENV') != 'production')
                                <li>
                                    <a href="{{url('user/config/impersonate')}}">
                                        {{ app('impersonate')->isImpersonating() ? 'Leave Impersonation' : 'Impersonate' }}
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<li class="nav-item">
    <a class="nav-link active" href="{{ url('attendances/0/'.Auth::user()->id.'/0') }}"><i class="material-icons">date_range</i>
        <span class="nav-link-text">My Attendance</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ url('courses/0/'.Auth::user()->section_id) }}"><i class="material-icons">subject</i>
        <span class="nav-link-text">My Courses</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ url('grades/'.Auth::user()->id) }}"><i class="material-icons">bubble_chart</i> <span
                class="nav-link-text">My Grade</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="#"><i class="material-icons">payment</i> <span class="nav-link-text">Payment History</span></a>
</li>