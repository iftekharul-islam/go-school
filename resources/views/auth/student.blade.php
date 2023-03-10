@extends('layouts.student-app')

@section('title', 'Register Student')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            </a>Create Student
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Create Student</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
{{--            <div class="heading-layout1">--}}
{{--                <div class="item-title">--}}
{{--                    <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 10px;">Back</h4></a>--}}
{{--                    <h3>Register Student</h3>--}}
{{--                </div>--}}
{{--            </div>--}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="panel panel-default mt-5">
                <div class="panel-body">
                    <form class="new-added-form" method="POST" id="registerForm" action="{{ url('register/'.session('register_role')) }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Full Name</label>

                                    <div class="col-md-12">
                                        <input id="name" type="text" class="form-control" name="name"
                                               value="{{ old('name') }}"
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
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                    <div class="col-md-12">
                                        <input id="email" type="email" class="form-control" name="email"
                                               value="{{ old('email') }}" required>

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
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>

                                    <div class="col-md-12">
                                        <input id="password" type="password" class="form-control" name="password"
                                               required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-4 control-label">Confirm
                                        Password</label>

                                    <div class="col-md-12">
                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation"
                                               required>
                                    </div>
                                </div>
                            </div>
                        </div>
{{--                        @if(session('register_role', 'student') == 'student')--}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('section') ? ' has-error' : '' }}">
                                        <label for="section" class="col-md-4 control-label">Class and Section</label>

                                        <div class="col-md-12">
                                            <select id="section" class="form-control" name="section" required>
                                                @foreach (session('register_sections') as $section)
                                                    <option value="{{$section->id}}">
                                                        Section: {{$section->section_number}} Class:
                                                        {{$section->class->class_number}}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('section'))
                                                <span class="help-block">
                                    <strong>{{ $errors->first('section') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                                        <label for="birthday" class="col-md-4 control-label">Birthday</label>

                                        <div class="col-md-12">
                                            <input id="birthday" type="text" class="form-control" name="birthday"
                                                   value="{{ old('birthday') }}"
                                                   required>

                                            @if ($errors->has('birthday'))
                                                <span class="help-block">
                                    <strong>{{ $errors->first('birthday') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
{{--                        @endif--}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                    <label for="phone_number" class="col-md-4 control-label">Phone Number</label>

                                    <div class="col-md-12">
                                        <input id="phone_number" type="text" class="form-control" name="phone_number"
                                               value="{{ old('phone_number') }}">

                                        @if ($errors->has('phone_number'))
                                            <span class="help-block">
                                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('blood_group') ? ' has-error' : '' }}">
                                    <label for="blood_group" class="col-md-4 control-label">Blood Group</label>

                                    <div class="col-md-12">
                                        <select id="blood_group" class="form-control" name="blood_group">
                                            <option selected="selected">A+</option>
                                            <option>A-</option>
                                            <option>B+</option>
                                            <option>B-</option>
                                            <option>AB+</option>
                                            <option>AB-</option>
                                            <option>O+</option>
                                            <option>O-</option>
                                        </select>

                                        @if ($errors->has('blood_group'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('blood_group') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">
                                    <label for="nationality" class="col-md-4 control-label">Nationality</label>

                                    <div class="col-md-12">
                                        <input id="nationality" type="text" class="form-control" name="nationality"
                                               value="{{ old('nationality') }}"
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
                                <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                    <label for="gender" class="col-md-4 control-label">Gender</label>

                                    <div class="col-md-12">
                                        <select id="gender" class="form-control" name="gender">
                                            <option selected="selected">Male</option>
                                            <option>Female</option>
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
                        @if(session('register_role', 'student') == 'student')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('version') ? ' has-error' : '' }}">
                                        <label for="version" class="col-md-4 control-label">Version</label>

                                        <div class="col-md-12">
                                            <select id="version" class="form-control" name="version">
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
                                    <div class="form-group{{ $errors->has('session') ? ' has-error' : '' }}">
                                        <label for="session" class="col-md-4 control-label">Session</label>

                                        <div class="col-md-12">
                                            <input id="session" type="text" class="form-control" name="session"
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
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                                        <label for="group" class="col-md-4 control-label">Group (Optional)</label>

                                        <div class="col-md-12">
                                            <input id="group" type="text" class="form-control" name="group"
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
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        <label for="address" class="col-md-4 control-label">address</label>

                                        <div class="col-md-12">
                                            <input id="address" type="text" class="form-control" name="address"
                                                   value="{{ old('address') }}"
                                                   required>

                                            @if ($errors->has('address'))
                                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">
                                        <label for="about" class="col-md-4 control-label">About</label>

                                        <div class="col-md-12">
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

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('father_name') ? ' has-error' : '' }}">
                                        <label for="father_name" class="col-md-4 control-label">Father's Name</label>

                                        <div class="col-md-12">
                                            <input id="father_name" type="text" class="form-control" name="father_name"
                                                   value="{{ old('father_name') }}"
                                                   required>

                                            @if ($errors->has('father_name'))
                                                <span class="help-block">
                                    <strong>{{ $errors->first('father_name') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('father_phone_number') ? ' has-error' : '' }}">
                                        <label for="father_phone_number" class="col-md-4 control-label">Father's Phone
                                            Number</label>

                                        <div class="col-md-12">
                                            <input id="father_phone_number" type="text" class="form-control"
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
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('father_national_id') ? ' has-error' : '' }}">
                                        <label for="father_national_id" class="col-md-4 control-label">Father's National
                                            ID</label>

                                        <div class="col-md-12">
                                            <input id="father_national_id" type="text" class="form-control"
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
                                    <div class="form-group{{ $errors->has('father_occupation') ? ' has-error' : '' }}">
                                        <label for="father_occupation" class="col-md-4 control-label">Father's
                                            Occupation</label>

                                        <div class="col-md-12">
                                            <input id="father_occupation" type="text" class="form-control"
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
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('father_annual_income') ? ' has-error' : '' }}">
                                        <label for="father_annual_income" class="col-md-4 control-label">Father's Annual
                                            Income</label>

                                        <div class="col-md-12">
                                            <input id="father_annual_income" type="text" class="form-control"
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
                                    <div class="form-group{{ $errors->has('father_designation') ? ' has-error' : '' }}">
                                        <label for="father_designation" class="col-md-4 control-label">Father's
                                            Designation</label>

                                        <div class="col-md-12">
                                            <input id="father_designation" type="text" class="form-control"
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
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('mother_phone_number') ? ' has-error' : '' }}">
                                        <label for="mother_phone_number" class="col-md-4 control-label">Mother's Phone
                                            Number</label>

                                        <div class="col-md-12">
                                            <input id="mother_phone_number" type="text" class="form-control"
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
                                    <div class="form-group{{ $errors->has('mother_name') ? ' has-error' : '' }}">
                                        <label for="mother_name" class="col-md-4 control-label">Mother's Name</label>

                                        <div class="col-md-12">
                                            <input id="mother_name" type="text" class="form-control" name="mother_name"
                                                   value="{{ old('mother_name') }}"
                                                   required>

                                            @if ($errors->has('mother_name'))
                                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_name') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('mother_occupation') ? ' has-error' : '' }}">
                                        <label for="mother_occupation" class="col-md-4 control-label">Mother's
                                            Occupation</label>

                                        <div class="col-md-12">
                                            <input id="mother_occupation" type="text" class="form-control"
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
                                    <div class="form-group{{ $errors->has('mother_national_id') ? ' has-error' : '' }}">
                                        <label for="mother_national_id" class="col-md-4 control-label">Mother's National
                                            ID</label>

                                        <div class="col-md-12">
                                            <input id="mother_national_id" type="text" class="form-control"
                                                   name="mother_national_id"
                                                   value="{{ old('mother_national_id') }}">

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
                                    <div class="form-group{{ $errors->has('mother_designation') ? ' has-error' : '' }}">
                                        <label for="mother_designation" class="col-md-4 control-label">Mother's
                                            Designation</label>

                                        <div class="col-md-12">
                                            <input id="mother_designation" type="text" class="form-control"
                                                   name="mother_designation"
                                                   value="{{ old('mother_designation') }}">

                                            @if ($errors->has('mother_designation'))
                                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_designation') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('mother_annual_income') ? ' has-error' : '' }}">
                                        <label for="mother_annual_income" class="col-md-4 control-label">Mother's Annual
                                            Income</label>

                                        <div class="col-md-12">
                                            <input id="mother_annual_income" type="text" class="form-control"
                                                   name="mother_annual_income"
                                                   value="{{ old('mother_annual_income') }}">

                                            @if ($errors->has('mother_annual_income'))
                                                <span class="help-block">
                                    <strong>{{ $errors->first('mother_annual_income') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endif
                        <div class="form-group">
                            <label class="col-md-4 control-label">Upload Profile Picture</label>
                            <div class="col-md-12">
                                <input type="hidden" id="picPath" name="pic_path">
                                @component('components.file-uploader',['upload_type'=>'profile'])
                                @endcomponent
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" id="registerBtn" class="button button--text">
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
