@extends('layouts.student-app')

@section('title', 'All Classes and Sections')

@section('content')

    <div class="breadcrumbs-area">
        <h3>
            All Class
        </h3>
        <ul>
            <li><a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>All Classes</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body mt-4">
            <div class="row">
                @if(count($classes)> 0)
                    @foreach($classes as $class)
                        <?php $total_student = 0 ?>
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div>
                                    <h5 class="card-header text-muted text-left">
                                        <i style="font-size:24px;margin-left:-20px;" class="flaticon-books text-teal"></i>

                                        Class <strong class="text-capitalize">{{$class->class_number}}</strong>
                                        @if($class ->group) | Group <strong
                                                class="text-capitalize">{{ucfirst($class->group)}}</strong>
                                        @endif
                                    </h5>
                                </div>
                                <div class="card-body-customized">
                                    @foreach($class->sections as $sec)
                                        @php
                                            $total_student = $total_student + $sec->users->count();
                                        @endphp
                                    @endforeach
                                    <div>
                                        <h5 class="card-title text-muted">Total
                                            Section: {{ $class->sections->count() }}</h5>
                                        <h5 class="card-title text-muted">Total Student: {{ $total_student }}</h5>
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
                                                            Class Details
                                                            <i class="fa fa-caret-down"></i>
                                                        </button>
                                                        <div class="dropdown-content"
                                                             aria-labelledby="dropdownMenuButton">
                                                            @foreach($class->sections as $section)
                                                                <a href="{{ url('admin/school/section/details/'.$section->id. '?course=1') }}">
                                                                    Section:{{$section->section_number}}</a>
                                                            @endforeach
                                                        </div>

                                                    </div>
                                                </div>
                                            @else
                                                <div class="float-right">
                                                    <div class="dropdown">
                                                        <button
                                                                class="button button--primary font-weight-bold"
                                                                type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                            Class Details
                                                            <i class="fa fa-caret-down"></i>
                                                        </button>

                                                        <div class="dropdown-content" aria-labelledby="dropdownMenuButton">
                                                            <!-- <button disabled class="btn disabled text-dark font-weight-bold"
                                                                type="button" aria-expanded="false">
                                                                No Info Available
                                                            </button>                                               -->
                                                            <p class="text-center text-muted font-weight-bold">
                                                                No Info Available
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div>
                                                    </div>
                                                </div>
                                            @endif

                                                <div class="float-right">
                                                    <a role="button" class="button button--primary mr-3 font-weight-bold"
                                                       href="{{url('admin/academic/syllabus/'.$class->id)}}">View Syllabus</a>
                                                </div>

                                                @else

                                                    @if(count($class->sections) > 0)
                                                        <div class="float-right">
                                                            <div class="dropdown">
                                                                <button
                                                                        class="button button--primary font-weight-bold"
                                                                        type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                                        aria-haspopup="true" aria-expanded="false">
                                                                    Details
                                                                    <i class="fa fa-caret-down"></i>
                                                                </button>
                                                                <div class="dropdown-content" aria-labelledby="dropdownMenuButton">
                                                                    @foreach($class->sections as $section)
                                                                        <a href="{{ url('admin/section/details/attendance/'.$section->id.'?att=1') }}">Section: {{$section->section_number}}</a>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="float-right">
                                                            <div class="dropdown">
                                                                <button
                                                                        class="button button--primary font-weight-bold"
                                                                        type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                                        aria-haspopup="true" aria-expanded="false">
                                                                    Details
                                                                    <i class="fa fa-caret-down"></i>
                                                                </button>

                                                                <div class="dropdown-content" aria-labelledby="dropdownMenuButton">
                                                                    -->
                                                                    <p class="text-center text-muted font-weight-bold">
                                                                        No Info Available
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
                @endif
            </div>
        </div>
    </div>
@endsection
