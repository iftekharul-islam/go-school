@extends('layouts.student-app')

@section('title', 'Edit Shift')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-clock"></i>
            Update Shift
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Update Shift</li>
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
            <form class="new-added-form" method="POST" action="{{ route('shift.update',['id' => $shift->id]) }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('shift') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="shift" class="control-label false-padding-bottom">Shift<label class="text-danger">*</label></label>
                                <input id="shift" class="form-control" name="shift" value="{{$shift->shift}}" />
        
                                @if ($errors->has('shift'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('shift') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('last_attendance_time') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="last_attendance_time" class="control-label false-padding-bottom">Last Attendance Time<label class="text-danger">*</label></label>
                                <input id="last_attendance_time" type="time" class="form-control" name="last_attendance_time" value="{{$shift->last_attendance_time}}">
                                @if ($errors->has('last_attendance_time'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('last_attendance_time') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('exit_time') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="exit_time" class="control-label false-padding-bottom">Exit Time<label class="text-danger">*</label></label>
                                <input id="exit_time" type="time" class="form-control" name="exit_time" value="{{$shift->exit_time}}">
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
                            Update Shift
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        
@endsection

{{-- @push('customjs')
    <script>   
        function getSections(item) {
            let selectedClass = item.value;
            let classes = {!! json_encode($classes->toArray()) !!};
            let sections = [];
            classes.forEach((cls) => {
                if (cls.id == selectedClass) {
                    sections = cls.sections;
                }
            });
            $('#section_id').empty();
            sections.forEach((sec) => {
                $('#section_id').append($("<option />").val(sec.id).text(sec.section_number));
            });
        }
    </script>
@endpush --}}
