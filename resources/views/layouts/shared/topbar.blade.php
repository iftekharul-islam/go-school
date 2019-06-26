<div class="navbar navbar-expand-md header-menu-one bg-light">
    <div class="nav-bar-header-one">
        <div class="header-logo">
            <a href="{{ url('home') }}">
            
                <img class="logo float-left" src="{{ asset('/template/img/logo3.png') }}" alt="logo">
                 <h4 class="heading-logo float-right">shoroborno</h4>             
            </a>
        </div>
        <div class="toggle-button sidebar-toggle">
            <button type="button" class="item-link">
                        <span class="btn-icon-wrap">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
            </button>
        </div>
    </div>
    <div class="d-md-none mobile-nav-bar">
        <button class="navbar-toggler pulse-animation" type="button" data-toggle="collapse" data-target="#mobile-navbar" aria-expanded="false">
            <i class="far fa-arrow-alt-circle-down"></i>
        </button>
        <button type="button" class="navbar-toggler sidebar-toggle-mobile">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <div class="header-main-menu collapse navbar-collapse" id="mobile-navbar">
        <ul class="navbar-nav">
            <li class="navbar-item header-search-bar">
                <div class="input-group stylish-input-group">
                    @if(\Auth::check())
                        <span class="input-group-addon">
                                <button type="submit">
                                    <span class="flaticon-search" aria-hidden="true"></span>
                                </button>
                            </span>
                        <input type="text" class="form-control" placeholder="Find Something . . .">
                    @endif
                </div>
            </li>
        </ul>
        <ul class="navbar-nav">
            @guest
            @else
                <li class="navbar-item dropdown header-admin">
                    <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-expanded="false">
                        <div class="admin-title">
                            <h5 class="item-title">{{ Auth::user()->name }}</h5>
                            <span>{{ ucfirst(\Auth::user()->role) }}</span>
                        </div>
                        <div class="admin-img">
                            @if(\Auth::user()->role === 'admin' || \Auth::user()->role === 'master')
                                <img src="{{asset('template/img/user-default.png')}}" alt="Admin" style="width: 40px; height: 40px;">
                            @else
                                <img src="{{ \Auth::user()->pic_path }}" alt="{{ \Auth::user()->role  }}" style="width: 40px; height: 40px;">
                            @endif
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="item-header">
                            <h6 class="item-title">{{ Auth::user()->name }}</h6>
                        </div>
                        <div class="item-content">
                            <ul class="settings-list">
                                <li><a href="{{url('user/'.Auth::user()->student_code)}}"><i class="flaticon-user"></i>My Profile</a></li>
                                <li><a href="{{ url('user/config/change_password') }}"><i class="flaticon-list"></i>Change Password</a></li>
                                @if(env('APP_ENV') != 'production')
                                    <li>
                                        <a href="{{url('user/config/impersonate')}}"><i class="flaticon-gear-loading"></i>
                                            {{ app('impersonate')->isImpersonating() ? 'Leave Impersonation' : 'Impersonate' }}
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        <i class="flaticon-turn-off"></i>Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                @if(Auth::user()->role === 'student')
                    <li class="navbar-item header-message">
                        <a class="navbar-nav-link dropdown-toggle" href="{{ url('user/'.\Auth::user()->id.'/notifications') }}" role="button" aria-expanded="false">
                            <i class="far fa-envelope"></i>
                            <div class="item-title d-md-none text-16 mg-l-10">Message</div>
                            <?php
                            $mc = \App\Notification::where('student_id',\Auth::user()->id)->where('active',1)->count();
                            ?>
                            @if($mc > 0)
                                <span>{{$mc}}</span>
                            @endif
                        </a>
                    </li>
                @endif
                <li class="navbar-item dropdown header-notification">
                    <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-expanded="false">
                        <i class="far fa-bell"></i>
                        <div class="item-title d-md-none text-16 mg-l-10">Notification</div>
                        <span>8</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="item-header">
                            <h6 class="item-title">03 Notifiacations</h6>
                        </div>
                        <div class="item-content">
                            <div class="media">
                                <div class="item-icon bg-skyblue">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="media-body space-sm">
                                    <div class="post-title">Complete Today Task</div>
                                    <span>1 Mins ago</span>
                                </div>
                            </div>
                            <div class="media">
                                <div class="item-icon bg-orange">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="media-body space-sm">
                                    <div class="post-title">Director Metting</div>
                                    <span>20 Mins ago</span>
                                </div>
                            </div>
                            <div class="media">
                                <div class="item-icon bg-violet-blue">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div class="media-body space-sm">
                                    <div class="post-title">Update Password</div>
                                    <span>45 Mins ago</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="navbar-item dropdown header-language">
                    <a class="navbar-nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-expanded="false"><i class="fas fa-globe-americas"></i>EN</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#">English</a>
                        <a class="dropdown-item" href="#">Spanish</a>
                        <a class="dropdown-item" href="#">Franchis</a>
                        <a class="dropdown-item" href="#">Chiness</a>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</div>