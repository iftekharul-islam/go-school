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
                                <i class='fas fa-clock'></i> {{ __('text.Attendance Time') }}
                            </h3>
                            <ul>
                                <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                                        {{ __('text.Back') }}</a>|
                                    <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
                                </li>
                                <li>{{ __('text.Attendance') }}</li>
                                <li>{{ __('text.Configuration') }}</li>
                            </ul>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @elseif(session('error-status'))
                            <div class="alert alert-success">
                                {{ session('error-status') }}
                            </div>
                        @endif
                        <div class="card height-auto attendance-timings">
                            <div class="card-body">
                                <a href="{{ route('attendance.time.add') }}" class="btn btn-secondary float-right btn-lg mb-3"><b>{{ __('text.Create New Timing') }}</b></a>
                                <div class="clearfix"></div>
                                <div id="accordion">
                                    @if(!$classes->isEmpty())
                                    @foreach($classes as $key => $class)
                                    <div class="card">
                                    <div class="card-header" id="heading-{{$key}}">
                                            <h5 class="mb-0 d-inline ">
                                                <button class="btn btn-link cls-title" data-toggle="collapse" data-target="#collapse-{{$class->id}}" aria-expanded="true" aria-controls="collapse-{{$class->id}}">
                                                    {{ __('text.Class') }} {{ $class->class_number }}
                                                </button>
                                                </h5>
                                            
                                        </div>
                                        <div id="collapse-{{$class->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="card-body" id="child-{{$class->id}}">
                                                @if(!$class->sections->isEmpty())
                                                    @foreach($class->sections as $k => $section)
                                                        <div class="card">
                                                            <div class="card-header">
                                                            <a href="#" data-toggle="collapse" class="sec-title " data-target="#collapseSection-{{$section->id}}">{{ __('text.Section') }}: {{ $section->section_number }}</a>
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
                                                                <p class="mb-1"><b>{{ __('text.Shift') }}: </b>{{ ucfirst($timing->shift) }}
                                                                    </p>
                                                                    
                                                                <p class="mb-1"><b>{{ __('text.Last Attendance Time') }}: </b>{{ \Carbon\Carbon::parse($timing->last_attendance_time)->format('g:i A') }}</p>
                                                                <p class="mb-1"><b>{{ __('text.Exit Time') }}: </b>{{ \Carbon\Carbon::parse($timing->exit_time)->format('g:i A') }}</p>
                                                                <hr>
                                                                @endforeach
                                                                @else
                                                                <p>{{ __('text.No timing found') }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p>{{ __('text.No Section Found') }}</p>
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
                                        title: "{{ __('text.conform_msg') }}",
                                        text: "{{ __('text.conform_info') }}",
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
