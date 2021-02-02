@extends('layouts.student-app')

@section('title', 'Edit')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Edit {{ ucfirst($user->role) }}
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}">
                    Back &nbsp;&nbsp;|</a>
                <a href="{{ url(current_user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Edit {{ ucfirst($user->role) }}</li>
        </ul>
    </div>
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
    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="col-md-{{ (\Auth::user()->role == 'master')? 12 : 12 }}" id="main-container">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="new-added-form" method="POST" action="{{ route('edit.user') }}"
                              enctype='multipart/form-data'>
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <input type="hidden" name="user_role" value="{{$user->role}}">

                            @if($user->role == 'student')
                                <div class="offset-9 col-3 text-right">
                                    <div class="form-check">
                                        <input type='hidden' value="false" name='sms_enabled'>
                                        <input type="checkbox" name="sms_enabled" value="true"
                                               @if($user->studentInfo['is_sms_enabled']) checked
                                               @endif class="form-check-input checkAll" id="sms-enabled">
                                        <label class="form-check-label" for="sms-enabled">Is SMS enabled </label>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div
                                        class="false-padding-bottom-form form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="name" class="control-label false-padding-bottom">{{ __('text.Name') }}
                                                <label class="text-danger">*</label></label>
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
                                            <label for="email" class="control-label false-padding-bottom">{{ __('text.Email') }}
                                                <label class="text-danger">*</label></label>
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

                                @if($user->role == 'student')
                                    <div class="col-md-6">
                                        <div
                                            class="false-padding-bottom-form form-group{{ $errors->has('department') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="department" class="control-label false-padding-bottom">{{ __('text.Department') }}</label>
                                                <select id="department" class="form-control" name="department_id">
                                                    @if (count($departments)) > 0)
                                                    @foreach ($departments as $d)
                                                        <option value="{{ $d['id'] }}" {{ $d['id'] ==  $user->department_id ? 'selected' : '' }}>{{$d['department_name']}}</option>
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
                                        <div
                                            class="false-padding-bottom-form form-group{{ $errors->has('section') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                                <label for="section"
                                                       class="control-label false-padding-bottom">{{ __('text.class_section') }}<label class="text-danger">*</label></label>

                                                <select id="section" class="form-control" name="section" required>
                                                    @foreach ($sections as $section)
                                                        <option value="{{ $section->id }}"
                                                                @if($user->section_id == $section->id) selected @endif>
                                                            Section: {{ $section->section_number }}
                                                            Class: {{ $section->class->class_number }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @if ($errors->has('section'))
                                                    <span
                                                        class="help-block"><strong>{{ $errors->first('section') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="false-padding-bottom-form form-group{{ $errors->has('student_indentification') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="student_indentification"
                                                       class="control-label false-padding-bottom">{{ __('text.student_id') }}:</label>
                                                <input id="student_indentification" type="text" class="form-control"
                                                       name="student_indentification"
                                                       value="{{ $user->studentInfo['student_indentification'] }}">

                                                @if ($errors->has('student_indentification'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('student_indentification') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="false-padding-bottom-form form-group{{ $errors->has('roll_number') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="roll_number" class="control-label false-padding-bottom">{{ __('text.roll_number') }}:</label>
                                                <input id="roll_number" type="text" class="form-control"
                                                       name="roll_number"
                                                       value="{{ $user->studentInfo['roll_number'] }}">

                                                @if ($errors->has('roll_number'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('roll_number') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div
                                            class="false-padding-bottom-form form-group{{ $errors->has('shift') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="shift" class="control-label false-padding-bottom">{{ __('text.shift') }}</label>
                                                <select id="shift" class="form-control" name="shift">
                                                    <option value="n/a" {{ strtolower($user->studentInfo['shift']) == 'n/a' ? 'selected' : '' }}>N/A</option>
                                                    <option value="morning" {{ strtolower($user->studentInfo['shift']) == 'morning' ? 'selected' : '' }}>Morning</option>
                                                    <option value="day" {{ strtolower($user->studentInfo['shift']) == 'day' ? 'selected' : '' }}>Day</option>
                                                </select>
                                                @if ($errors->has('shift'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('shift') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div
                                        class="false-padding-bottom-form form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="phone_number" class="control-label false-padding-bottom">{{ __('text.phone_number') }}</label>
                                            <input id="phone_number" type="text" class="form-control"
                                                   name="phone_number"
                                                   value="{{ $user->phone_number }}">

                                            @if ($errors->has('phone_number'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if($user->role == 'student')
                                    <div class="col-md-6">
                                        <div
                                            class="false-padding-bottom-form form-group{{ $errors->has('address') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="address"
                                                       class="control-label false-padding-bottom">{{ __('text.address') }}</label>
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
                                @endif
                                @if($user->role == 'teacher')
                                    <div class="col-md-6">
                                        <div
                                            class="false-padding-bottom-form form-group{{ $errors->has('address') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="address"
                                                       class="control-label false-padding-bottom">Address<label
                                                        class="text-danger">*</label></label>
                                                <input id="address" type="text" class="form-control" name="address"
                                                       value="{{ $user->address }}" required>

                                                @if ($errors->has('address'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="false-padding-bottom-form form-group{{ $errors->has('department') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="department" class="control-label false-padding-bottom">Department</label>
                                                <select id="department" class="form-control" name="department_id" >
                                                    @if (count($departments)) > 0)
                                                        @foreach ($departments as $d)
                                                            <option value="{{$d['id']}}" {{ $d['id'] ==  $user->department_id ? 'selected' : '' }}>{{$d['department_name']}}</option>
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
                                        <div
                                            class="false-padding-bottom-form form-group{{ $errors->has('class_teacher') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="class_teacher" class="control-label false-padding-bottom">Class
                                                    Teacher</label>
                                                <select id="class_teacher" class="form-control"
                                                        name="class_teacher_section_id">
                                                    @if(isset($user->section['id']))
                                                        <option selected="selected" value="{{$user->section['id']}}">
                                                            Section:
                                                            {{$user->section['section_number']}} Class:
                                                            {{$user->section['class']['class_number']}}</option>
                                                    @endif
                                                    @foreach ($sections as $section)
                                                        <option value="{{$section['id']}}">
                                                            Section: {{$section['section_number']}}
                                                            Class:
                                                            {{$section['class']['class_number']}}</option>
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
                                    <div class="col-md-6">
                                        <div
                                            class="false-padding-bottom-form form-group{{ $errors->has('class_teacher') ? ' has-error' : '' }}">
                                            <div class="col-md-12">
                                            <label for="class_teacher"
                                                   class="control-label false-padding-bottom">Shift</label>
                                            <select id="class_teacher" class="form-control" name="shift_id">
                                                @if( count($shifts) > 0 )
                                                    @foreach ($shifts as $shift)
                                                        <option value="{{$shift['id']}}"
                                                                @if($shift->id == $user->shift_id) selected @endif>{{ $shift['shift'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6">
                                    <div
                                        class="false-padding-bottom-form form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="nationality" class="control-label false-padding-bottom">{{ __('text.nationality') }}</label>
                                            <input id="nationality" type="text" class="form-control" name="nationality"
                                                   value="{{ $user->nationality }}">

                                            @if ($errors->has('nationality'))
                                                <span class="help-block">
                                    <strong>{{ $errors->first('nationality') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div
                                        class="false-padding-bottom-form form-group{{ $errors->has('gender') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="gender" class="control-label false-padding-bottom">{{ __('text.gender') }} <label
                                                    class="text-danger">*</label></label>
                                            <select id="gender" class="form-control" name="gender">
                                                <option @if($user->gender == 'Male') selected="selected" @endif>Male
                                                </option>
                                                <option @if($user->gender == 'Female') selected="selected" @endif>
                                                    Female
                                                </option>
                                            </select>

                                            @if ($errors->has('gender'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('gender') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div
                                        class="false-padding-bottom-form form-group{{ $errors->has('blood_group') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="blood_group" class="control-label false-padding-bottom">{{ __('text.blood_group') }}</label>
                                            @php
                                                $blood_groups = blood_groups();
                                            @endphp
                                            <select id="blood_group" class="form-control" name="blood_group">
                                                @foreach($blood_groups as $item)
                                                    <option value="{{ $item }}" {{ $item == $user->blood_group ? 'selected' : '' }}>{{ $item }}</option>
                                                @endforeach
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
                                    <div
                                        class="false-padding-bottom-form form-group{{ $errors->has('about') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="about" class="control-label false-padding-bottom">{{ __('text.about') }}</label>
                                            <textarea id="about" class="form-control"
                                                      name="about">{{ $user->about }}</textarea>

                                            @if ($errors->has('about'))
                                                <span class="help-block">
                                    <strong>{{ $errors->first('about') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if($user->role == 'student')
                                    <div class="col-md-6">
                                        <div
                                            class="false-padding-bottom-form form-group {{ $errors->has('version') ? 'has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="version" class="control-label false-padding-bottom">{{ __('text.version') }}<label class="text-danger">*</label></label>
                                                <select id="version" class="form-control" name="version">
                                                    <option value="bangla" {{ strtolower($user->version) == 'bangla' ? 'selected' : '' }}>Bangla</option>
                                                    <option value="english" {{ strtolower($user->version) == 'english' ? 'selected' : '' }}>English</option>
                                                    <option
                                                        @if($user->version == 'Bangla & English') selected="selected"
                                                        @endif value="Bangla & English">Bangla & English
                                                    </option>
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
                                        <div
                                            class="false-padding-bottom-form form-group{{ $errors->has('session') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="session" class="control-label false-padding-bottom">{{ __('text.session') }}<label class="text-danger">*</label></label>
                                                <input id="session" type="text" class="form-control" name="session"
                                                       value="{{ $user->studentInfo['session'] }}" required>

                                                @if ($errors->has('session'))
                                                    <span class="help-block">
                                <strong>{{ $errors->first('session') }}</strong>
                            </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                                            <label for="group" class="col-md-4 control-label">{{ __('text.group') }}</label>

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
                                        <div class="form-group{{ $errors->has('guardian_name') ? ' has-error' : '' }}">
                                            <label for="guardian_name" class="col-md-6 control-label">{{ __('text.guardian') }}<label class="text-danger">*</label></label>

                                            <div class="col-md-12">
                                                <input id="guardian_name" type="text" class="form-control"
                                                       name="guardian_name"
                                                       value="{{ $user->studentInfo['guardian_name'] }}" required>

                                                @if ($errors->has('guardian_name'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('guardian_name') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="form-group{{ $errors->has('guardian_phone_number') ? ' has-error' : '' }}">
                                            <label for="guardian_phone_number" class="col-md-8 control-label">{{ __('text.guardian_phone_number') }}<label class="text-danger">*</label></label>

                                            <div class="col-md-12">
                                                <input id="guardian_phone_number" type="text" class="form-control"
                                                       name="guardian_phone_number"
                                                       required
                                                       value="{{ $user->studentInfo['guardian_phone_number'] }}">

                                                @if ($errors->has('guardian_phone_number'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('guardian_phone_number') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('father_name') ? ' has-error' : '' }}">
                                            <label for="father_name" class="col-md-6 control-label">{{ __('text.father_name') }}</label>

                                            <div class="col-md-12">
                                                <input id="father_name" type="text" class="form-control"
                                                       name="father_name"
                                                       value="{{ $user->studentInfo['father_name'] }}">

                                                @if ($errors->has('father_name'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('father_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="form-group{{ $errors->has('father_phone_number') ? ' has-error' : '' }}">
                                            <label for="father_phone_number" class="col-md-8 control-label">{{ __('text.phone_number') }}</label>

                                            <div class="col-md-12">
                                                <input id="father_phone_number" type="text" class="form-control"
                                                       name="father_phone_number"
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
                                        <div
                                            class="form-group{{ $errors->has('father_national_id') ? ' has-error' : '' }}">
                                            <label for="father_national_id" class="col-md-8 control-label">{{ __('text.father_nid') }}</label>

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
                                    <div class="col-md-6">
                                        <div
                                            class="false-padding-bottom-form form-group{{ $errors->has('father_occupation') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="father_occupation"
                                                       class="control-label false-padding-bottom">{{ __('text.father_occupation') }}</label>
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
                                        <div
                                            class="false-padding-bottom-form form-group{{ $errors->has('father_designation') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="father_designation"
                                                       class="control-label false-padding-bottom">{{ __('text.father_designation') }}</label>
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
                                    <div class="col-md-6">
                                        <div
                                            class="false-padding-bottom-form form-group{{ $errors->has('father_annual_income') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="father_annual_income"
                                                       class="control-label false-padding-bottom">{{ __('text.father_income') }}</label>
                                                <input id="father_annual_income" type="number" class="form-control"
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
                                        <div
                                            class="false-padding-bottom-form form-group{{ $errors->has('mother_name') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="mother_name" class="control-label false-padding-bottom">{{ __('text.mother_name') }}</label>
                                                <input id="mother_name" type="text" class="form-control"
                                                       name="mother_name"
                                                       value="{{ $user->studentInfo['mother_name'] }}">

                                                @if ($errors->has('mother_name'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('mother_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div
                                            class="form-group{{ $errors->has('mother_phone_number') ? ' has-error' : '' }}">
                                            <label for="mother_phone_number" class="col-md-8 control-label">{{ __('text.phone_number') }}</label>

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
                                        <div
                                            class="form-group{{ $errors->has('mother_national_id') ? ' has-error' : '' }}">
                                            <label for="mother_national_id" class="col-md-8 control-label">{{ __('text.mother_nid') }}</label>

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
                                    <div class="col-md-6">
                                        <div
                                            class="false-padding-bottom-form form-group{{ $errors->has('mother_occupation') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="mother_occupation"
                                                       class="control-label false-padding-bottom">{{ __('text.mother_occupation') }}</label>
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
                                        <div
                                            class="false-padding-bottom-form form-group{{ $errors->has('mother_designation') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="mother_designation"
                                                       class="control-label false-padding-bottom">{{ __('text.mother_designation') }}</label>
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
                                    <div class="col-md-6">
                                        <div
                                            class="form-group{{ $errors->has('mother_annual_income') ? ' has-error' : '' }}">
                                            <label for="mother_annual_income" class="col-md-8 control-label">{{ __('text.mother_income') }}</label>

                                            <div class="col-md-12">
                                                <input id="mother_annual_income" type="number" class="form-control"
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
                                            <label for="birthday" class="col-md-4 control-label">{{ __('text.birthday') }}<label
                                                    class="text-danger">*</label></label>

                                            <div class="col-md-12">
                                                <input data-date-format="yyyy-mm-dd" id="birthday"
                                                       class="form-control date" name="birthday"
                                                       placeholder="Birthday" required
                                                       autocomplete="off"
                                                       value="{{ \Carbon\Carbon::parse($user->studentInfo['birthday'])->toDateString() }}">
                                                @if ($errors->has('birthday'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('birthday') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('religion') ? ' has-error' : '' }}">
                                            <label for="religion" class="col-md-4 control-label">{{ __('text.religion') }}</label>

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
                                @endif
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <div class="col-md-12">
                                            <label class="control-label">{{ __('text.upload_picture') }}</label>
                                            <br>
                                            <input type="file" id="pic_path" name="pic_path"
                                                   value="{{ $user->pic_path }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12 text-right form">
                                    <a href="{{ URL::previous() }}" class="button button--cancel"
                                       style="margin-right: 2%;"
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
