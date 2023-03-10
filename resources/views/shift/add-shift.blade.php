@extends('layouts.student-app')

@section('title', 'Create Shift')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-clock"></i>
            {{ __('text.create_shift') }}
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.create_shift') }}</li>
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
            <form class="new-added-form" method="POST" action="{{ route('shift.store') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('shift') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="shift" class="control-label false-padding-bottom">{{ __('text.shift') }}<label class="text-danger">*</label></label>
                                <input id="shift" class="form-control" name="shift" value="{{old('shift')}}" />
        
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
                                <label for="last_attendance_time" class="control-label false-padding-bottom">{{ __('text.last_attendance') }}<label class="text-danger">*</label></label>
                                <input id="last_attendance_time" type="time" class="form-control" name="last_attendance_time" value="{{ old('last_attendance_time') }}">
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
                                <label for="exit_time" class="control-label false-padding-bottom">{{ __('text.Exit Time') }}<label class="text-danger">*</label></label>
                                <input id="exit_time" type="time" class="form-control" name="exit_time" value="{{ old('exit_time') }}">
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
                            {{ __('text.create') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        
@endsection

