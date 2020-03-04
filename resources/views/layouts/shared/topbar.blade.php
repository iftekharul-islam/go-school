<div class="navbar navbar-expand-md header-menu-one bg-light">
    <div class="nav-bar-header-one">
            @if(\Auth::check())
                @php
                    $x = \Illuminate\Support\Facades\Auth::user()->role;
                    $school = \App\School::find(\Illuminate\Support\Facades\Auth::user()->school_id);
                @endphp
                <a href="{{ url($x.'/home') }}">
                    @if($school && $school->logo && $x != 'master')
                        <div class="school-logo">
                         <img class="logo topbar-logo-mg float-left" src="{{ asset($school->logo) }}">
                        </div>
                    @else
                        <div class="header-logo">
                            <img class="logo float-left" src="{{ asset('/logos/header-logo.png') }}" alt="logo">
{{--                            <h5 class="heading-logo float-right">shoroborno</h5>--}}
                        </div>
                    @endif
                </a>
            @endif

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
        <button class="navbar-toggler pulse-animation" type="button" data-toggle="collapse" data-target="#mobile-navbar"
                aria-expanded="false">
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
                    @if(\Auth::check() && \Auth::user()->role === 'admin')
                        <span class="input-group-addon">
                                <button type="submit">
                                    <span class="flaticon-search" aria-hidden="true"></span>
                                </button>
                            </span>
                        <form action="{{ url('admin/search-user/') }}" method="get">
                            {{ csrf_field() }}
                            <input type="text" class="typeahead form-control" name="search" id="search"
                                   placeholder="Find Something . . .">
                        </form>
                    @endif
                </div>
            </li>
        </ul>
        <ul class="navbar-nav">
            <div class="mr-3">
                @if(app()->getLocale() == 'en')
                    <a class="btn btn-info text-white ml-2" href=" {{ url('locale/bn') }}">Bn</a>
                @else
                    <a class="btn btn-info text-white" href="{{ url('locale/en') }}">En</a>
                @endif
            </div>
{{--            <div class="mr-3">--}}
{{--                <a class="btn btn-info text-white" href="{{ url('locale/en') }}">En</a>--}}
{{--                <a class="btn btn-info text-white ml-2" href=" {{ url('locale/bn') }}">Bn</a>--}}
{{--            </div>--}}
            @guest
            @else
                @if(Auth::user()->role === 'student')
                    <li class="navbar-item header-message">
                        <a class="navbar-nav-link dropdown-toggle"
                           href="{{ url('student/user/notifications/'.\Auth::user()->id) }}" role="button"
                           aria-expanded="false">
                            <i class="far fa-envelope"></i>
                            <div class="item-title d-md-none text-16 mg-l-10">Message</div>
                            <?php
                            $mc = \App\Notification::where('student_id', \Auth::user()->id)->where('active', 1)->count();
                            ?>
                            @if($mc > 0)
                                <span>{{$mc}}</span>
                            @endif
                        </a>
                    </li>
                @endif
                <li class="navbar-item dropdown header-admin">
                    <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-expanded="false">
                        <div class="admin-title">
                            <h5 class="item-title">{{ Auth::user()->name }}</h5>
                            <span>{{ ucfirst(\Auth::user()->role) }}</span>
                        </div>
                        <div class="admin-img">
                            @if( \Auth::user()->role === 'master')
                                <img src="{{asset('template/img/user-default.png')}}" alt="Admin"
                                     style="width: 40px; height: 40px;">
                            @else
                                @if(Auth::user()->pic_path)
                                    <img src="{{url(Auth::user()->pic_path)}}" alt="{{ Auth::user()->role  }}"
                                         style="width: 40px; height: 40px;">
                                    @else
                                    <img src="{{asset('template/img/user-default.png')}}" alt="Admin"
                                         style="width: 40px; height: 40px;">
                                    @endif
                            @endif
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="item-header">
                            <h6 class="item-title">{{ Auth::user()->name }}</h6>
                        </div>
                        <div class="item-content">
                            <ul class="settings-list">
                                @if(Auth::user()->role != 'master')
                                    <li><a href="{{url('user/'.Auth::user()->student_code)}}"><i
                                                    class="flaticon-user"></i>{{ __('text.my_profile') }}</a></li>
                                @endif
                                <li><a href="{{ url('user/config/change_password') }}"><i class="flaticon-list"></i>{{ __('text.change_password') }}</a></li>
                                @if(env('APP_ENV') != 'production')
                                    <li>
                                        <a href="{{url('user/config/impersonate')}}"><i
                                                    class="flaticon-gear-loading"></i>
                                            {{ app('impersonate')->isImpersonating() ? __('text.leave_impersonation') : __('text.impersonate') }}
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        <i class="flaticon-turn-off"></i>{{ __('text.logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</div>
<script>
    var path = "{{ url('admin/find-user/{query}') }}";
    $('input.typeahead').typeahead({
        source: function (query, process) {
            return $.get(path + $('#search').val(), {}, function (data) {
                return process(data);
            });
        }
    });
</script>
