@extends('layouts.student-app')

@section('title', 'Add Attendance Time')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-clock"></i>
            Edit Attendance Time
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Attendance</li>
            <li><a href="{{route('configure.attendance.time')}}">Configuration</a></li>
            <li>Edit Attendance Time</li>
        </ul>
    </div>
    <div class="card height-auto mb-5">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="card-body">
            <form class="new-added-form" method="POST" enctype="multipart/form-data"
                  id="attendanceTime" action="{{ route('attendance.time.update',['id' => $sectionMeta->id]) }}">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('class_id') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="class_id" class="control-label false-padding-bottom">Class</label>
                                <select id="class_id" class="form-control select2" name="class_id" onchange="getSections(this)" >
                                    <option value="" disabled selected>Select Class</option>
                                    @foreach ($classes as $class)
                                        <option value="{{$class->id}}">{{ $class->class_number }}</option>    
                                    @endforeach
                                </select>
                                @if ($errors->has('class_id'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('class_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('section_id') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="section_id" class="control-label false-padding-bottom">Section<label class="text-danger">*</label></label>
                                <select id="section_id" class="form-control select2" name="section_id" >
                                     <option value="{{$sectionMeta->section_id}}" selected>{{$sectionMeta->section_id}}</option> 
                                </select>
                                @if ($errors->has('section_id'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('section_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('shift') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <label for="shift" class="control-label false-padding-bottom">Shift<label class="text-danger">*</label></label>
                                <select id="shift" type="email" class="form-control select2" name="shift" required>
                                    <option value="">Select shift</option>
                                    <option value="morning" @if($sectionMeta->shift == 'morning') selected @endif>Morning</option>
                                    <option value="evening" @if($sectionMeta->shift == 'evening') selected @endif>Evening</option>
                                </select>
                                @if ($errors->has('shift'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('shift') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('last_attendance_time') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="last_attendance_time" class="control-label false-padding-bottom">Last Attendance Time<label class="text-danger">*</label></label>
                                <input id="last_attendance_time" type="time" class="form-control" name="last_attendance_time" value="{{$sectionMeta->last_attendance_time}}" required>
                                @if ($errors->has('last_attendance_time'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('last_attendance_time') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('exit_time') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="exit_time" class="control-label false-padding-bottom">Exit Time<label class="text-danger">*</label></label>
                                <input id="exit_time" type="time" class="form-control" name="exit_time" value="{{$sectionMeta->exit_time}}" required>
                                @if ($errors->has('exit_time'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('exit_time') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 col-md-offset-4">
                        <button type="submit" id="registerBtn" class="button button--save float-right">
                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
        </div>
        
@endsection

@push('customjs')
    <script>   
        function getSections(item) {
            let selectedClass = item.value;
            let classes = {!! json_encode($classes->toArray()) !!};
            let currentSectionId = {{$sectionMeta->section_id}};
            let sections = [];
            classes.forEach((cls) => {
                if (cls.id == selectedClass) {
                    sections = cls.sections;
                }
            });
            $('#section_id').empty();
            sections.forEach((sec) => {
                let isSelected = '';
                if(sec.id == currentSectionId){isSelected = 'selected'}
                $('#section_id').append($("<option isSelected />").val(sec.id).text(sec.section_number));
            });
        }
    </script>
@endpush
