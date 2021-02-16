@extends('layouts.student-app')

@section('title', 'All Classes and Sections')

@section('content')

    <div class="breadcrumbs-area">
        <h3>
            <i class='fas fa-chalkboard'></i>
            {{ __('text.All Classes') }}
        </h3>
        <ul>
            <li><a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }}</a>|
                <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.All Classes') }}</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="row">
                @if($classFilterByDepartments->count() > 0)
                    @foreach($classFilterByDepartments as $class)
                        <?php $total_student = 0 ?>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                            <div class="card mb-4">
                                <div>
                                    <h5 class="card-sub-header text-muted text-left">
                                        <i style="font-size:24px;margin-left:-20px;"
                                           class="flaticon-books text-teal"></i>

                                        {{ __('text.Class') }} <strong class="text-capitalize">{{$class->class_number}}</strong>
                                        @if($class ->group) | Group <strong
                                                class="text-capitalize">{{ucfirst($class->group)}}</strong>
                                        @endif
                                    </h5>
                                </div>
                                <div class="card-body-customized">
                                    @foreach($class->sections as $sec)
                                        @php
                                            $total_student = $total_student + $sec->users->where('role', 'student')->where('active', 1)->where('section_id', '=' ,  $sec->id)->count();
                                        @endphp
                                    @endforeach
                                    <div>
                                        <h5 class="card-title text-muted">{{ _('text.sections') }}: {{ $class->sections->count() }}</h5>
                                        <h5 class="card-title text-muted"> {{ _('text.Total Student') }}: {{ $total_student }}</h5>
                                    </div>
                                    <div class="">
                                        @if(isset($_GET['course']) && $_GET['course'] == 1)
                                            @if(count($class->sections) > 0)
                                                <div class="float-right">
                                                    <div class="dropdown">
                                                        <button
                                                                class="button button--primary font-weight-bold"
                                                                type="button" id="dropdownMenuButton"
                                                                data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                            {{ __('text.Details') }}
                                                            <i class="fa fa-caret-down"></i>
                                                        </button>
                                                        <div class="dropdown-content"
                                                             aria-labelledby="dropdownMenuButton">
                                                            @foreach($class->sections as $section)
                                                                <a href="{{ url('admin/school/section/details/'.$section->id. '?course=1') }}">
                                                                    {{ __('text.Section') }}: {{$section->section_number}}</a>
                                                            @endforeach
                                                        </div>

                                                    </div>
                                                </div>
                                            @else
                                                <div class="float-right">
                                                    <div class="dropdown">
                                                        <button
                                                                class="button button--primary font-weight-bold"
                                                                type="button" id="dropdownMenuButton"
                                                                data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                            {{ __('text.Details') }}
                                                            <i class="fa fa-caret-down"></i>
                                                        </button>

                                                        <div class="dropdown-content"
                                                             aria-labelledby="dropdownMenuButton">
                                                            <!-- <button disabled class="btn disabled text-dark font-weight-bold"
                                                                type="button" aria-expanded="false">
                                                                No Info Available
                                                            </button>                                               -->
                                                            <p class="text-center text-muted font-weight-bold">
                                                                {{ __('text.No Info Available') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="float-right">
                                                <a role="button" class="button button--primary mr-3 font-weight-bold"
                                                   href="{{url('admin/academic/syllabus/'.$class->id)}}">View
                                                    Syllabus</a>
                                            </div>

                                        @else

                                            @if(count($class->sections) > 0)
                                                <div class="float-right">
                                                    <div class="dropdown">
                                                        <button
                                                                class="button button--primary font-weight-bold"
                                                                type="button" id="dropdownMenuButton"
                                                                data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                            {{ __('text.Details') }}
                                                            <i class="fa fa-caret-down"></i>
                                                        </button>
                                                        <div class="dropdown-content"
                                                             aria-labelledby="dropdownMenuButton">
                                                            @foreach($class->sections as $section)
                                                                <a href="{{ url('admin/section/details/attendance/'.$section->id.'?att=1') }}">{{ __('text.Section') }}: {{$section->section_number}}</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="float-right">
                                                    <div class="dropdown">
                                                        <button
                                                                class="button button--primary font-weight-bold"
                                                                type="button" id="dropdownMenuButton"
                                                                data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                            {{ __('text.Details') }}
                                                            <i class="fa fa-caret-down"></i>
                                                        </button>

                                                        <div class="dropdown-content"
                                                             aria-labelledby="dropdownMenuButton">
                                                            <p class="text-center text-muted font-weight-bold">
                                                                {{ __('text.No Info Available') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    @if(count($classes)> 0)
                        @foreach($classes as $class)
                            <?php $total_student = 0 ?>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                                <div class="card mb-4">
                                    <div>
                                        <h5 class="card-sub-header text-muted text-left">
                                            <i style="font-size:24px;margin-left:-20px;"
                                               class="flaticon-books text-teal"></i>

                                            {{ __('text.Class') }} <strong class="text-capitalize">{{$class->class_number}}</strong>
                                            @if($class ->group) | Group <strong
                                                    class="text-capitalize">{{ucfirst($class->group)}}</strong>
                                            @endif
                                        </h5>
                                    </div>
                                    <div class="card-body-customized">
                                        @foreach($class->sections as $sec)
                                            @php
                                                $total_student = $total_student + $sec->users->where('role', 'student')->where('active', 1)->where('section_id', '=' ,  $sec->id)->count();
                                            @endphp
                                        @endforeach
                                        <div>
                                            <h5 class="card-title text-muted">{{ __('text.Total Sections') }}: {{ $class->sections->count() }}</h5>
                                            <h5 class="card-title text-muted">{{ __('text.Total Students') }}: {{ $total_student }}</h5>
                                        </div>
                                        <div class="">
                                            @if(isset($_GET['course']) && $_GET['course'] == 1)
                                                @if(count($class->sections) > 0)
                                                    <div class="float-right">
                                                        <div class="dropdown">
                                                            <button
                                                                    class="button button--primary font-weight-bold"
                                                                    type="button" id="dropdownMenuButton"
                                                                    data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                {{ __('text.Details') }}
                                                                <i class="fa fa-caret-down"></i>
                                                            </button>
                                                            <div class="dropdown-content"
                                                                 aria-labelledby="dropdownMenuButton">
                                                                @foreach($class->sections as $section)
                                                                    <a href="{{ url('admin/school/section/details/'.$section->id. '?course=1') }}">
                                                                        {{ __('text.Section') }}: {{$section->section_number}}</a>
                                                                @endforeach
                                                            </div>

                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="float-right">
                                                        <div class="dropdown">
                                                            <button
                                                                    class="button button--primary font-weight-bold"
                                                                    type="button" id="dropdownMenuButton"
                                                                    data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                {{ __('text.Details') }}
                                                                <i class="fa fa-caret-down"></i>
                                                            </button>

                                                            <div class="dropdown-content"
                                                                 aria-labelledby="dropdownMenuButton">
                                                                <!-- <button disabled class="btn disabled text-dark font-weight-bold"
                                                                    type="button" aria-expanded="false">
                                                                    No Info Available
                                                                </button>                                               -->
                                                                <p class="text-center text-muted font-weight-bold">
                                                                    {{ __('text.No Info Available') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="float-right">
                                                    <a role="button"
                                                       class="button button--primary mr-3 font-weight-bold"
                                                       href="{{url('admin/academic/syllabus/'.$class->id)}}">{{ __('text.view_syllabus') }}</a>
                                                </div>

                                            @else

                                                @if(count($class->sections) > 0)
                                                    <div class="float-right">
                                                        <div class="dropdown">
                                                            <button
                                                                    class="button button--primary font-weight-bold"
                                                                    type="button" id="dropdownMenuButton"
                                                                    data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                {{ __('text.Details') }}
                                                                <i class="fa fa-caret-down"></i>
                                                            </button>
                                                            <div class="dropdown-content"
                                                                 aria-labelledby="dropdownMenuButton">
                                                                @foreach($class->sections as $section)
                                                                    <a href="{{ url('admin/section/details/attendance/'.$section->id.'?att=1') }}">{{ __('text.Section') }}: {{$section->section_number}}</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="float-right">
                                                        <div class="dropdown">
                                                            <button
                                                                    class="button button--primary font-weight-bold"
                                                                    type="button" id="dropdownMenuButton"
                                                                    data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                {{ __('text.Details') }}
                                                                <i class="fa fa-caret-down"></i>
                                                            </button>

                                                            <div class="dropdown-content"
                                                                 aria-labelledby="dropdownMenuButton">
                                                                <p class="text-center text-muted font-weight-bold">
                                                                    {{ __('text.No Info Available') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @else
                        <div class="card-body mt-5 text-center">
                            <h5>{{ __('text.No_related_data_notification') }}</h5>
                        </div>
                    @endif
                @endif

            </div>
        </div>
    </div>
@endsection
