@extends('layouts.student-app')

@section('title', 'Attendance Time')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" id="main-container">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="breadcrumbs-area">
                            <h3>
                                <i class='fas fa-clock'></i>  Attendance Time
                            </h3>
                            <ul>
                                <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                                        Back &nbsp;&nbsp;|</a>
                                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                                </li>
                                <li>Attendance</li>
                                <li>Configuration</li>
                            </ul>
                        </div>

                        <div class="card height-auto attendance-timings">
                            <div class="card-body">

                                @if (session('status'))
                                    <div class="alert alert-success">
                                        {{ session('status') }}
                                    </div>
                                @elseif(session('error-status'))
                                    <div class="alert alert-success">
                                        {{ session('error-status') }}
                                    </div>
                                @endif

                                <a href="{{ route('attendance.time.add') }}" class="btn btn-secondary float-right btn-lg mb-3"><b>Create New Timing</b></a>
                                <div class="clearfix"></div>
                                <div id="accordion">
                                    @if(!$classes->isEmpty())
                                    @foreach($classes as $key => $class)
                                    <div class="card">
                                    <div class="card-header" id="heading-{{$key}}">
                                            <h5 class="mb-0 d-inline ">
                                                <button class="btn btn-link cls-title" data-toggle="collapse" data-target="#collapse-{{$class->id}}" aria-expanded="true" aria-controls="collapse-{{$class->id}}">
                                                    Class {{ $class->class_number }}
                                                </button>
                                                </h5>
                                            
                                        </div>
                                        <div id="collapse-{{$class->id}}" class="collapse @if($key == 0) show @endif" aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="card-body" id="child-{{$class->id}}">
                                                @if(!$class->sections->isEmpty())
                                                    @foreach($class->sections as $k => $section)
                                                        <div class="card">
                                                            <div class="card-header">
                                                            <a href="#" data-toggle="collapse" class="sec-title" data-target="#collapseSection-{{$section->id}}">Section: {{ $section->section_number }}</a>
                                                            </div>
                                                            <div class="card-body collapse" data-parent="#child-{{$class->id}}" id="collapseSection-{{$section->id}}">
                                                                @if(!$section->attendanceTimes->isEmpty())
                                                                @foreach($section->attendanceTimes as $timing)
                                                                <span class="float-right">
                                                                    <a href="{{route('attendance.time.edit',['id' => $timing->id])}}" class="btn btn-delete btn-primary btn-md mr-1" title="Edit">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <form id="timing-{{$timing->id}}" class="d-md-inline-block" action="{{route('attendance.time.delete',['id' => $timing->id])}}" method="POST"> 
                                                                        {{method_field('DELETE')}}
                                                                        {{ csrf_field() }}
                                                                        <button type='button' onclick="removeTiming('timing-{{$timing->id}}')" class="btn btn-delete btn-danger btn-md" title="Delete">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </span>
                                                                <p class="mb-1"><b>Shift: </b>{{ ucfirst($timing->shift) }}  
                                                                    </p>
                                                                    
                                                                <p class="mb-1"><b>Last Attendance Time: </b>{{ \Carbon\Carbon::parse($timing->last_attendance_time)->format('g:i A') }}</p>
                                                                <p class="mb-1"><b>Exit Time: </b>{{ \Carbon\Carbon::parse($timing->exit_time)->format('g:i A') }}</p>
                                                                <hr>
                                                                @endforeach
                                                                @else
                                                                <p>No timing found</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p>No Section Found</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        @push('customjs')
                            <script type="text/javascript">
                                function removeTiming(id) {
                                    swal({
                                        title: "Are you sure?",
                                        text: "Once deleted, you will not be able to recover!",
                                        icon: "warning",
                                        buttons: true,
                                        dangerMode: true,
                                    })
                                        .then((willDelete) => {
                                            if (willDelete) {
                                                document.getElementById(id).submit();
                                            }
                                        });
                                }
                            </script>
                        @endpush
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
