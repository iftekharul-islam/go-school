@extends('layouts.student-app')

@section('title', 'School Setting')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-cogs"></i>
            {{ __('text.school_setting') }}
        </h3>
        <ul>
            <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }}</a>|
                <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.school_setting') }}</li>
        </ul>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card height-auto mb-5">

        <div class="card-body">
            <form class="new-added-form" method="POST"
                  action="{{ route('school.update',['school_id' => $school->id]) }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div
                            class="false-padding-bottom-form form-group{{ $errors->has('school_address') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="class_id" class="control-label false-padding-bottom">{{ __('text.address') }} <label
                                        class="text-danger">*</label> </label>
                                <textarea class="form-control" name="school_address"
                                          required>{{$school->school_address}}</textarea>
                                @if ($errors->has('school_address'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('school_address') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div
                            class="false-padding-bottom-form form-group{{ $errors->has('about') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="section_id" class="control-label false-padding-bottom">{{ __('text.about') }} <label
                                        class="text-danger">*</label></label>
                                <textarea class="form-control" name="about" required>{{$school->about}}</textarea>
                                @if ($errors->has('about'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('about') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div
                            class="false-padding-bottom-form form-group{{ $errors->has('medium') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <label for="shift" class="control-label false-padding-bottom">{{ __('text.medium') }} <label
                                        class="text-danger">*</label></label>
                                <select class="form-control" name="medium" required>
                                    <option value="" selected disabled>Select Medium</option>
                                    <option value="bangla" @if($school->medium == 'bangla') selected @endif>Bangla
                                    </option>
                                    <option value="english" @if($school->medium == 'english') selected @endif>English
                                    </option>
                                    <option value="bangla & english"
                                            @if($school->medium == 'bangla & english') selected @endif>Bangla & English
                                    </option>
                                </select>
                                @if ($errors->has('medium'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('medium') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div
                            class="false-padding-bottom-form form-group{{ $errors->has('absent_msg') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="last_attendance_time" class="control-label false-padding-bottom">{{ __('text.Absent') }} {{ __('text.message') }}<label class="text-danger">*</label></label>
                                <textarea class="form-control" name="absent_msg" maxlength="140"
                                          required>{{$school->absent_msg}}</textarea>
                                <small class="font-italic text-muted">{{ __('text.max_character') }}</small>
                                @if ($errors->has('absent_msg'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('absent_msg') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div
                            class="false-padding-bottom-form form-group{{ $errors->has('present_msg') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="exit_time" class="control-label false-padding-bottom">{{ trans_choice('text.Present', 2) }} {{ __('text.message') }}<label
                                        class="text-danger">*</label> </label>
                                <textarea class="form-control" name="present_msg" maxlength="140"
                                          required>{{$school->present_msg}}</textarea>
                                <small class="font-italic text-muted">{{ __('text.max_character') }}</small>
                                @if ($errors->has('present_msg'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('present_msg') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 col-md-offset-4">
                        <button type="submit" id="registerBtn" class="button button--save float-right">{{ __('text.Update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
