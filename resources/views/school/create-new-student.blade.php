@extends('layouts.student-app')

@section('title', 'Create Student')

@section('content')
    <div class="dashboard-content-one" >
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-user-plus"></i>
            Add Student
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Add Student</li>
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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="false-height">
            <div class="card height-auto">
                <div class="card-body">
                    <form class="new-added-form" method="POST" id="registerForm"
                          enctype="multipart/form-data"
                          action="{{ route('register.student.store') }}">
                        {{ csrf_field() }}
                        <div class="row mb-3">
                            <div class="offset-9 col-3 text-right">
                                <div class="form-check mr-4">
                                    <input type='hidden' value="false" name='sms_enabled'>
                                    <input type="checkbox" name="sms_enabled" value="true" class="form-check-input checkAll" id="sms-enabled">
                                    <label class="form-check-label" for="sms-enabled">Is SMS enabled </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                    <div class="col-md-12">
                                        <label for="name"
                                               class="control-label false-padding-bottom">Full
                                            Name<label class="text-danger">*</label></label>
                                        <input id="name" type="text" class="form-control student-name"
                                               name="name" value="{{ old('name') }}"
                                               required>

                                        @if ($errors->has('name'))
                                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                    <div class="col-md-12">
                                        <label for="email"
                                               class="control-label false-padding-bottom">E-Mail/Username<label
                                                class="text-danger">*</label></label>
                                        <a href="" class="btn btn-primary btn-sm email-enable-button float-right">Enable email</a>

                                        @php
                                            $code = auth()->user()->school_id . date('y') . substr(number_format(time() * mt_rand(), 0, '', ''), 0, 5)
                                        @endphp

                                        <input type="hidden" name="student_code" value="{{ $code }}">

                                        <input id="email" type="email" class="form-control student-username"
                                               name="email" value="{{ old('email') }}"
                                               required readonly>
                                        <div class="email-visible"></div>

                                        @if ($errors->has('email'))
                                            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="password"
                                               class="control-label false-padding-bottom">Password<label
                                                class="text-danger">*</label></label>
                                        <button class="btn btn-primary btn-sm password-btn float-right">Create Password</button>
                                        <input id="password" type="password"
                                               class="form-control student-password" name="password"
                                               required readonly>

                                        @if ($errors->has('password'))
                                            <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group">

                                    <div class="col-md-12">
                                        <label for="password-confirm"
                                               class="control-label false-padding-bottom">Confirm
                                            Password<label
                                                class="text-danger">*</label></label>

                                        <input id="password-confirm" type="password"
                                               class="form-control student-password"
                                               name="password_confirmation" required readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('department') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="department"
                                               class=" control-label false-padding-bottom">Department</label>

                                        <select id="department" class="form-control"
                                                name="department_id">
                                            <option value="{{ old('department_id') }}" selected> --Select Option-- </option>
                                            @if (count($departments) > 0)
                                                @foreach ($departments as $department)
                                                    <option value="{{$department->id}}">{{$department->department_name}}</option>
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
                                <div class="false-padding-bottom-form form-group{{ $errors->has('section') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="section"
                                               class="control-label false-padding-bottom">Class
                                            and Section<label class="text-danger">*</label></label>

                                        <select id="section" class="form-control"
                                                name="section" required>
                                            @foreach ($studentSections as $section)
                                                <option value="{{$section->id}}">
                                                    Section:
                                                    {{$section->section_number}}
                                                    Class:
                                                    {{$section->class->class_number}}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('section'))
                                            <span class="help-block"><strong>{{ $errors->first('section') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('student_indentification') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="student_indentification"
                                               class="control-label false-padding-bottom">Student ID:</label>
                                        <input id="student_indentification"  type="text"
                                               class="form-control"
                                               name="student_indentification">

                                        @if ($errors->has('student_indentification'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('student_indentification') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('roll_number') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="roll_number"
                                               class="control-label false-padding-bottom">Roll Number:</label>
                                        <input id="roll_number"  type="text"
                                               class="form-control"
                                               name="roll_number">

                                        @if ($errors->has('roll_number'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('roll_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('shift') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="shift"
                                               class="control-label false-padding-bottom">Shift</label>

                                        <select id="shift" class="form-control"
                                                name="shift">
                                            <option selected="selected">N/A</option>
                                            <option>Morning</option>
                                            <option>Day</option>
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
                                <div class="false-padding-bottom-form form-group{{ $errors->has('version') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="version"
                                               class="control-label false-padding-bottom">Version<label
                                                class="text-danger">*</label></label>

                                        <select id="version" class="form-control"
                                                name="version">
                                            <option selected="selected">Bangla</option>
                                            <option>English</option>
                                        </select>

                                        @if ($errors->has('version'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('version') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('session') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="session"
                                               class="control-label false-padding-bottom">Session<label
                                                class="text-danger">*</label></label>

                                        <input id="session" type="text" class="form-control"
                                               name="session"
                                               value="{{ old('session') }}"
                                               required>

                                        @if ($errors->has('session'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('session') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="group"
                                               class=" control-label false-padding-bottom">Group
                                            (Optional)</label>

                                        <input id="group" type="text" class="form-control"
                                               name="group"
                                               value="{{ old('group') }}"
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
                                <div class="false-padding-bottom-form form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="phone_number"
                                               class="control-label false-padding-bottom">Phone
                                            Number</label>

                                        <input id="phone_number" type="text"
                                               class="form-control"  name="phone_number"
                                               value="{{ old('phone_number') }}">

                                        @if ($errors->has('phone_number'))
                                            <span class="help-block"><strong>{{ $errors->first('phone_number') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="birthday"
                                               class="control-label false-padding-bottom">Birthday<label
                                                class="text-danger">*</label></label>

                                        <input data-date-format="yyyy-mm-dd" id="birthday"
                                               class="form-control date" name="birthday"
                                               value="{{ old('birthday') }}"
                                               placeholder="Birthday" required
                                               autocomplete="off">

                                        @if ($errors->has('birthday'))
                                            <span class="help-block"><strong>{{ $errors->first('birthday') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('blood_group') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="blood_group"
                                               class=" control-label false-padding-bottom">Blood
                                            Group<label
                                                class="text-danger">*</label></label>

                                        <select id="blood_group" class="form-control"
                                                name="blood_group">
                                            <option selected="selected">N/A</option>
                                            <option>A+</option>
                                            <option>A-</option>
                                            <option>B+</option>
                                            <option>B-</option>
                                            <option>AB+</option>
                                            <option>AB-</option>
                                            <option>O+</option>
                                            <option>O-</option>
                                        </select>

                                        @if ($errors->has('blood_group'))
                                            <span class="help-block"><strong>{{ $errors->first('blood_group') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="nationality"
                                               class=" control-label false-padding-bottom">Nationality</label>

                                        <input id="nationality" type="text"
                                               class="form-control" name="nationality"
                                               value="{{ old('nationality') }}">

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
                                        <label for="gender"
                                               class="control-label false-padding-bottom">Gender</label>

                                        <select id="gender" class="form-control"
                                                name="gender">
                                            <option class="text-capitalize" value="male"
                                                    selected="selected">Male
                                            </option>
                                            <option class="text-capitalize" value="female">
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
                                <div class="false-padding-bottom-form form-group{{ $errors->has('religion') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="religion"
                                               class=" control-label false-padding-bottom">Religion<label
                                                class="text-danger">*</label></label>

                                        <select id="religion" class="form-control"
                                                name="religion">
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
                            <div class="col-md-12">
                                <input type="checkbox" class="f-name ml-4"><span class="f-name ml-2">Is Guardian</span>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('father_name') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="father_name"
                                               class=" control-label false-padding-bottom">Father's
                                            Name <label class="father-n"></label></label>

                                        <input id="father_name" type="text"
                                               class="form-control father-name" name="father_name"
                                               value="{{ old('father_name') }}">

                                        @if ($errors->has('father_name'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('father_name') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('father_phone_number') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="father_phone_number" class="control-label false-padding-bottom">Father's Phone Number<label class="father-n"></label></label>
                                        <input id="father_phone_number"  type="text"
                                               class="form-control f-phone-number"
                                               name="father_phone_number"
                                               value="{{ old('father_phone_number') }}">

                                        @if ($errors->has('father_phone_number'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('father_phone_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('father_national_id') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="father_national_id"
                                               class="control-label false-padding-bottom">Father's
                                            National ID</label>
                                        <input id="father_national_id" type="text"
                                               class="form-control"
                                               name="father_national_id"
                                               value="{{ old('father_national_id') }}">

                                        @if ($errors->has('father_national_id'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('father_national_id') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('father_occupation') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="father_occupation"
                                               class=" control-label false-padding-bottom">Father's
                                            Occupation</label>
                                        <input id="father_occupation" type="text"
                                               class="form-control"
                                               name="father_occupation"
                                               value="{{ old('father_occupation') }}">

                                        @if ($errors->has('father_occupation'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('father_occupation') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('father_annual_income') ? ' has-error' : '' }}">

                                    <div class="col-md-12">
                                        <label for="father_annual_income"
                                               class="control-label false-padding-bottom">Father's
                                            Annual
                                            Income</label>
                                        <input id="father_annual_income" type="number"
                                               class="form-control"
                                               name="father_annual_income"
                                               value="{{ old('father_annual_income') }}">

                                        @if ($errors->has('father_annual_income'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('father_annual_income') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('father_designation') ? ' has-error' : '' }}">

                                    <div class="col-md-12">
                                        <label for="father_designation"
                                               class=" control-label false-padding-bottom">Father's
                                            Designation</label>

                                        <input id="father_designation" type="text"
                                               class="form-control"
                                               name="father_designation"
                                               value="{{ old('father_designation') }}">

                                        @if ($errors->has('father_designation'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('father_designation') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="checkbox" class="m-name ml-4"><span class="m-name ml-2">Is Guardian</span>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('mother_name') ? ' has-error' : '' }}">

                                    <div class="col-md-12">

                                        <label for="mother_name"
                                               class=" control-label false-padding-bottom">Mother's
                                            Name<label class="mother-n"></label></label>

                                        <input id="mother_name" type="text"
                                               class="form-control mother-name" name="mother_name"
                                               value="{{ old('mother_name') }}">

                                        @if ($errors->has('mother_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('mother_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('mother_phone_number') ? ' has-error' : '' }}">

                                    <div class="col-md-12">
                                        <label for="mother_phone_number"
                                               class="control-label false-padding-bottom">Mother's
                                            Phone
                                            Number<label class="mother-n"></label></label>

                                        <input id="mother_phone_number" type="text"
                                               class="form-control m-phone-number"
                                               name="mother_phone_number"
                                               value="{{ old('mother_phone_number') }}">

                                        @if ($errors->has('mother_phone_number'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('mother_phone_number') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('mother_occupation') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="mother_occupation"
                                               class="control-label false-padding-bottom">Mother's
                                            Occupation</label>

                                        <input id="mother_occupation" type="text"
                                               class="form-control"
                                               name="mother_occupation"
                                               value="{{ old('mother_occupation') }}">

                                        @if ($errors->has('mother_occupation'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('mother_occupation') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('mother_national_id') ? ' has-error' : '' }}">

                                    <div class="col-md-12">
                                        <label for="mother_national_id"
                                               class=" control-label false-padding-bottom">Mother's National ID</label>

                                        <input id="mother_national_id"  type="text"
                                               class="form-control"
                                               name="mother_national_id"
                                               value="{{ old('mother_national_id') }}"
                                        >

                                        @if ($errors->has('mother_national_id'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('mother_national_id') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('mother_designation') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="mother_designation"
                                               class="control-label false-padding-bottom">Mother's
                                            Designation</label>
                                        <input id="mother_designation" type="text"
                                               class="form-control"
                                               name="mother_designation"
                                               value="{{ old('mother_designation') }}"
                                        >

                                        @if ($errors->has('mother_designation'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('mother_designation') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('mother_annual_income') ? ' has-error' : '' }}">

                                    <div class="col-md-12">
                                        <label for="mother_annual_income"
                                               class=" control-label false-padding-bottom">Mother's
                                            Annual
                                            Income</label>
                                        <input id="mother_annual_income" type="number"
                                               class="form-control"
                                               name="mother_annual_income"
                                               value="{{ old('mother_annual_income') }}"
                                        >

                                        @if ($errors->has('mother_annual_income'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('mother_annual_income') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 guardian-field">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('guardian_name') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="guardian_name"
                                               class=" control-label false-padding-bottom">Guardian's Name<label class="text-danger">*</label></label>

                                        <input id="guardian_name" type="text"
                                               class="form-control guardian-name" name="guardian_name"
                                               value="{{ old('guardian_name') }}"
                                               required>

                                        @if ($errors->has('guardian_name'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('guardian_name') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 guardian-field">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('guardian_phone_number') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="guardian_phone_number"
                                               class="control-label false-padding-bottom">Guardian's Phone Number<label
                                                class="text-danger">*</label></label>
                                        <input id="guardian_phone_number"  type="text"
                                               class="form-control g-phone-number"
                                               name="guardian_phone_number"
                                               value="{{ old('guardian_phone_number') }}"required>

                                        @if ($errors->has('guardian_phone_number'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('guardian_phone_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="address"
                                               class="control-label false-padding-bottom">Address</label>

                                        <input id="address" type="text" class="form-control"
                                               name="address"
                                               value="{{ old('address') }}">

                                        @if ($errors->has('address'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('about') ? ' has-error' : '' }}">

                                    <div class="col-md-12">
                                        <label for="about"
                                               class=" control-label false-padding-bottom">About</label>

                                        <textarea id="about" class="form-control"
                                                  name="about">{{ old('about') }}</textarea>

                                        @if ($errors->has('about'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('about') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <label class=" control-label">Upload Profile Picture</label>
                                <br> <input type="file"  id="picPath" name="student_pic">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-4">
                                <button type="submit" id="registerBtn"
                                        class="button button--save float-right">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('customjs')
    <script>
        $(document).ready(function() {

            $('.student-name').focusout(function() {
                let inputName = $('.student-name').val();
                if (inputName) {
                    let names = inputName.split(' ');

                    let code = {!! $code !!};

                    let lastName = names[names.length - 1] ? names[names.length - 1] : names[names.length - 2];

                    let username = lastName + code;

                    $('.student-username').val(username.toLowerCase());

                    $('.student-password').val(username.toLowerCase());

                }
            });

            $('.email-enable-button').click(function(event) {
                event.preventDefault();

                $('.student-username').remove();
                $('.email-visible').html(`<input id="email" type="email" class="form-control student-email"
                           name="email" value="" placeholder="Enter email address"
                           required>`);
                $('.email-enable-button').remove();
                $('.student-password').val('').removeAttr('readonly');
                $('.password-btn').remove();
            });

            $('.password-btn').click(function(event) {
                event.preventDefault();

                $('.student-password').val('').removeAttr('readonly');

                $('.password-btn').remove();
            });


            $('.f-name').on('click', function(){
                if($(this).prop("checked") == true){
                    $('.guardian-name').val($('.father-name').val());
                    $('.g-phone-number').val($('.f-phone-number').val());
                    $('.father-n').addClass('text-danger').text('*');
                    $(".father-name, .f-phone-number").prop('required', true);

                     $('.father-name').keyup(function () {
                         $('.guardian-name').val($('.father-name').val());
                    });

                    $('.f-phone-number').keyup(function () {
                        $('.g-phone-number').val($('.f-phone-number').val());
                    });
                    $('.guardian-field').hide();
                    $('.m-name').hide();

                }
                else if($(this).prop("checked") == false){
                    $('.guardian-name').val('');
                    $('.g-phone-number').val('');
                    $('.father-n').removeClass('text-danger').text('');
                    $('.father-name, .f-phone-number').prop('required', false);

                    $('.father-name').keyup(function () {
                        $('.guardian-name').val('');
                    });
                    $('.f-phone-number').keyup(function () {
                        $('.g-phone-number').val('');
                    });
                    $('.guardian-field').show();
                    $('.m-name').show();
                }
            });

            $('.m-name').on('click',function(){
                if($(this).prop("checked") == true){
                    $('.guardian-name').val($('.mother-name').val());
                    $('.g-phone-number').val($('.m-phone-number').val());
                    $('.mother-n').addClass('text-danger').text('*');
                    $(".mother-name, .f-phone-number").prop('required', true);

                    $('.mother-name').keyup(function () {
                        $('.guardian-name').val($('.mother-name').val());
                    });

                    $('.m-phone-number').keyup(function () {
                        $('.g-phone-number').val($('.m-phone-number').val());
                    });
                    $('.guardian-field').hide();
                    $('.f-name').hide();


                }
                else if($(this).prop("checked") == false){
                    $('.guardian-name').val('');
                    $('.g-phone-number').val('');
                    $('.mother-n').removeClass('text-danger').text('');
                    $(".mother-name, .f-phone-number").prop('required', false);

                    $('.mother-name').keyup(function () {
                        $('.guardian-name').val('');
                    });
                    $('.m-phone-number').keyup(function () {
                        $('.g-phone-number').val('');
                    });
                    $('.guardian-field').show();
                    $('.f-name').show();
                }
            });
        });
    </script>
@endpush
