@extends('layouts.student-app')

@section('title', 'Edit')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Edit {{ ucfirst($user->role) }}
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Edit {{ ucfirst($user->role) }}</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="col-md-{{ (\Auth::user()->role == 'master')? 12 : 12 }}" id="main-container">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @elseif(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="new-added-form" method="POST" action="{{ route('edit.user') }}" enctype='multipart/form-data'>
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <input type="hidden" name="user_role" value="{{$user->role}}">

                            @if($user->role == 'student')
                                <div class="offset-9 col-3 text-right">
                                    <div class="form-check">
                                        <input type='hidden' value="false" name='sms_enabled'>
                                        <input type="checkbox" name="sms_enabled" value="true" @if($user->studentInfo['is_sms_enabled']) checked @endif class="form-check-input checkAll" id="sms-enabled">
                                        <label class="form-check-label" for="sms-enabled">Is SMS enabled</label>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="false-padding-bottom-form form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="name" class="control-label false-padding-bottom">Full Name <label class="text-danger">*</label></label>
                                            <input id="name" type="text" class="form-control" name="name"
                                                   value="{{ $user->name }}"
                                                   required>

                                            @if ($errors->has('name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="email" class="control-label false-padding-bottom">E-Mail/Username <label class="text-danger">*</label></label>
                                            <input id="email" type="text" class="form-control" name="email"
                                                   value="{{ $user->email }}">

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="false-padding-bottom-form form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="phone_number" class="control-label false-padding-bottom">Phone Number</label>
                                            <input id="phone_number" type="text" class="form-control" name="phone_number"
                                                   value="{{ $user->phone_number }}">

                                            @if ($errors->has('phone_number'))
                                                <span class="help-block">
                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="false-padding-bottom-form form-group{{ $errors->has('address') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="address" class="control-label false-padding-bottom">Address <label class="text-danger">*</label></label>
                                            <input id="address" type="text" class="form-control" name="address"
                                                   value="{{ $user->address }}">

                                            @if ($errors->has('address'))
                                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($user->role == 'teacher')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="false-padding-bottom-form form-group{{ $errors->has('department') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="department" class="control-label false-padding-bottom">Department <label class="text-danger">*</label></label>
                                                <select id="department" class="form-control" name="department_id">
                                                    @if (count($departments)) > 0)
                                                    @foreach ($departments as $d)
                                                        <option value="{{$d->id}}">{{$d->department_name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>

                                                @if ($errors->has('department'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('department') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="false-padding-bottom-form form-group{{ $errors->has('class_teacher') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="class_teacher" class="control-label false-padding-bottom">Class Teacher</label>
                                                <select id="class_teacher" class="form-control" name="class_teacher_section_id">
                                                    <option selected="selected" value="{{$user->section->id}}">Section:
                                                        {{$user->section->section_number}} Class:
                                                        {{$user->section->class->class_number}}</option>
                                                    @foreach ($sections as $section)
                                                        <option value="{{$section->id}}">Section: {{$section->section_number}}
                                                            Class:
                                                            {{$section->class->class_number}}</option>
                                                    @endforeach
                                                </select>

                                                @if ($errors->has('class_teacher'))
                                                    <span class="help-block">
                                    <strong>{{ $errors->first('class_teacher') }}</strong>
                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="false-padding-bottom-form form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="nationality" class="control-label false-padding-bottom">Nationality <label class="text-danger">*</label></label>
                                            <input id="nationality" type="text" class="form-control" name="nationality"
                                                   value="{{ $user->nationality }}"
                                                   required>

                                            @if ($errors->has('nationality'))
                                                <span class="help-block">
                                    <strong>{{ $errors->first('nationality') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="false-padding-bottom-form form-group{{ $errors->has('gender') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="gender" class="control-label false-padding-bottom">Gender <label class="text-danger">*</label></label>
                                            <select id="gender" class="form-control" name="gender">
                                                <option @if($user->gender == 'Male') selected="selected" @endif>Male</option>
                                                <option @if($user->gender == 'Female') selected="selected" @endif>Female</option>
                                            </select>

                                            @if ($errors->has('gender'))
                                                <span class="help-block">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="false-padding-bottom-form form-group{{ $errors->has('blood_group') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="blood_group" class="control-label false-padding-bottom">Blood Group <label class="text-danger">*</label></label>
                                            <select id="blood_group" class="form-control" name="blood_group">
                                                <option @if($user->blood_group == 'A+') selected="selected" @endif value="A+">A+</option>
                                                <option @if($user->blood_group == 'A-') selected="selected" @endif value="A-">A-</option>
                                                <option @if($user->blood_group == 'B+') selected="selected" @endif value="B+">B+</option>
                                                <option @if($user->blood_group == 'B-') selected="selected" @endif value="B-">B-</option>
                                                <option @if($user->blood_group == 'AB+') selected="selected" @endif value="AB+">AB+</option>
                                                <option @if($user->blood_group == 'AB-') selected="selected" @endif value="AB-">AB-</option>
                                                <option @if($user->blood_group == 'O+') selected="selected" @endif value="O+">O+</option>
                                                <option @if($user->blood_group == 'O-') selected="selected" @endif value="O-">O-</option>
                                            </select>

                                            @if ($errors->has('blood_group'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('blood_group') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="false-padding-bottom-form form-group{{ $errors->has('about') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="about" class="control-label false-padding-bottom">About</label>
                                            <textarea id="about" class="form-control" name="about">{{ $user->about }}</textarea>

                                            @if ($errors->has('about'))
                                                <span class="help-block">
                                    <strong>{{ $errors->first('about') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($user->role == 'student')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="false-padding-bottom-form form-group {{ $errors->has('version') ? 'has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="version" class="control-label false-padding-bottom">Version <label class="text-danger">*</label></label>
                                                <select id="version" class="form-control" name="version">
                                                    <option @if($user->version == 'Bangla') selected="selected" @endif value="Bangla">Bangla</option>
                                                    <option @if($user->version == 'English') selected="selected" @endif value="English">English</option>
                                                    <option @if($user->version == 'Bangla & English') selected="selected" @endif value="Bangla & English">Bangla & English</option>
                                                </select>

                                                @if ($errors->has('blood_group'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('blood_group') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="false-padding-bottom-form form-group{{ $errors->has('session') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="session" class="control-label false-padding-bottom">Session  <label class="text-danger">*</label></label>
                                                <input id="session" type="text" class="form-control" name="session" value="{{ $user->studentInfo['session'] }}" required>

                                                @if ($errors->has('session'))
                                                    <span class="help-block">
                                    <strong>{{ $errors->first('session') }}</strong>
                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                                            <label for="group" class="col-md-4 control-label">Group</label>

                                            <div class="col-md-12">
                                                <input id="group" type="text" class="form-control" name="group"
                                                       value="{{ $user->studentInfo['group'] }}"
                                                       placeholder="Science, Arts, Commerce,etc.">

                                                @if ($errors->has('group'))
                                                    <span class="help-block">
                                    <strong>{{ $errors->first('group') }}</strong>
                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('father_name') ? ' has-error' : '' }}">
                                            <label for="father_name" class="col-md-6 control-label">Father's Name <label class="text-danger">*</label></label>

                                            <div class="col-md-12">
                                                <input id="father_name" type="text" class="form-control" name="father_name"
                                                       value="{{ $user->studentInfo['father_name'] }}" required>

                                                @if ($errors->has('father_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('father_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('father_phone_number') ? ' has-error' : '' }}">
                                            <label for="father_phone_number" class="col-md-8 control-label">Father's Phone
                                                Number <label class="text-danger">*</label></label>

                                            <div class="col-md-12">
                                                <input id="father_phone_number" type="text" class="form-control"
                                                       name="father_phone_number"
                                                       required
                                                       value="{{ $user->studentInfo['father_phone_number'] }}">

                                                @if ($errors->has('father_phone_number'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('father_phone_number') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('father_national_id') ? ' has-error' : '' }}">
                                            <label for="father_national_id" class="col-md-8 control-label">Father's National
                                                ID</label>

                                            <div class="col-md-12">
                                                <input id="father_national_id" type="text" class="form-control"
                                                       name="father_national_id"
                                                       value="{{ $user->studentInfo['father_national_id'] }}">

                                                @if ($errors->has('father_national_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('father_national_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="false-padding-bottom-form form-group{{ $errors->has('father_occupation') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="father_occupation" class="control-label false-padding-bottom">Father's
                                                    Occupation</label>
                                                <input id="father_occupation" type="text" class="form-control"
                                                       name="father_occupation"
                                                       value="{{ $user->studentInfo['father_occupation'] }}">

                                                @if ($errors->has('father_occupation'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('father_occupation') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="false-padding-bottom-form form-group{{ $errors->has('father_designation') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="father_designation" class="control-label false-padding-bottom">Father's
                                                    Designation</label>
                                                <input id="father_designation" type="text" class="form-control"
                                                       name="father_designation"
                                                       value="{{ $user->studentInfo['father_designation'] }}">

                                                @if ($errors->has('father_designation'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('father_designation') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="false-padding-bottom-form form-group{{ $errors->has('father_annual_income') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="father_annual_income" class="control-label false-padding-bottom">Father's Annual
                                                    Income</label>
                                                <input id="father_annual_income" type="text" class="form-control"
                                                       name="father_annual_income"
                                                       value="{{ $user->studentInfo['father_annual_income'] }}">

                                                @if ($errors->has('father_annual_income'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('father_annual_income') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="false-padding-bottom-form form-group{{ $errors->has('mother_name') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="mother_name" class="control-label false-padding-bottom">Mother's Name <label class="text-danger">*</label></label>
                                                <input id="mother_name" type="text" class="form-control" name="mother_name"
                                                       value="{{ $user->studentInfo['mother_name'] }}" required>

                                                @if ($errors->has('mother_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('mother_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('mother_phone_number') ? ' has-error' : '' }}">
                                            <label for="mother_phone_number" class="col-md-8 control-label">Mother's Phone
                                                Number</label>

                                            <div class="col-md-12">
                                                <input id="mother_phone_number" type="text" class="form-control"
                                                       name="mother_phone_number"
                                                       value="{{ $user->studentInfo['mother_phone_number'] }}">

                                                @if ($errors->has('mother_phone_number'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('mother_phone_number') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('mother_national_id') ? ' has-error' : '' }}">
                                            <label for="mother_national_id" class="col-md-8 control-label">Mother's National
                                                ID</label>

                                            <div class="col-md-12">
                                                <input id="mother_national_id" type="text" class="form-control"
                                                       name="mother_national_id"
                                                       value="{{ $user->studentInfo['mother_national_id'] }}">

                                                @if ($errors->has('mother_national_id'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('mother_national_id') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="false-padding-bottom-form form-group{{ $errors->has('mother_occupation') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="mother_occupation" class="control-label false-padding-bottom">Mother's
                                                    Occupation</label>
                                                <input id="mother_occupation" type="text" class="form-control"
                                                       name="mother_occupation"
                                                       value="{{ $user->studentInfo['mother_occupation'] }}">

                                                @if ($errors->has('mother_occupation'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('mother_occupation') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="false-padding-bottom-form form-group{{ $errors->has('mother_designation') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="mother_designation" class="control-label false-padding-bottom">Mother's
                                                    Designation</label>
                                                <input id="mother_designation" type="text" class="form-control"
                                                       name="mother_designation"
                                                       value="{{ $user->studentInfo['mother_designation'] }}">
                                                @if ($errors->has('mother_designation'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('mother_designation') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('mother_annual_income') ? ' has-error' : '' }}">
                                            <label for="mother_annual_income" class="col-md-8 control-label">Mother's Annual
                                                Income</label>

                                            <div class="col-md-12">
                                                <input id="mother_annual_income" type="text" class="form-control"
                                                       name="mother_annual_income"
                                                       value="{{ $user->studentInfo['mother_annual_income'] }}">

                                                @if ($errors->has('mother_annual_income'))
                                                    <span class="help-block">
                                        <strong>{{ $errors->first('mother_annual_income') }}</strong>
                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                                            <label for="birthday" class="col-md-4 control-label">Birthday <label class="text-danger">*</label></label>

                                            <div class="col-md-12">
                                                <input data-date-format="yyyy-mm-dd" id="birthday"
                                                       class="form-control date" name="birthday"
                                                       placeholder="Birthday" required
                                                       autocomplete="off" value="{{ \Carbon\Carbon::parse($user->studentInfo['birthday'])->toDateString() }}">
                                                @if ($errors->has('birthday'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('birthday') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('religion') ? ' has-error' : '' }}">
                                            <label for="religion" class="col-md-4 control-label">Religion</label>

                                            <div class="col-md-12">
                                                <select id="religion" class="form-control" name="religion">
                                                    <option selected="selected">Islam</option>
                                                    <option>Hinduism</option>
                                                    <option>Christianism</option>
                                                    <option>Buddhism</option>
                                                    <option>Other</option>
                                                </select>

                                                @if ($errors->has('religion'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('religion') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                </div>
                                    <div class="col-md-6">
                                        <div class="form-group">

                                            <div class="col-md-12">
                                                <label class="control-label">Edit Profile Picture</label>
                                                <br>
                                                <input type="file" id="pic_path" name="pic_path" value="{{ $user->pic_path }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <div class="col-md-12 text-right form">
                                    <a href="{{ URL::previous() }}" class="button button--cancel" style="margin-right: 2%;"
                                       role="button">Cancel</a>
                                    <input type="submit" role="button" class="button button--save" value="Save">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
