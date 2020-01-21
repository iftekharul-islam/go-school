@extends('layouts.student-app')

@section('title', 'Create Teacher')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-user-plus"></i>
            Add Teacher
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Add Teacher</li>
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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
            <form class="new-added-form" method="POST" enctype="multipart/form-data"
                  id="registerForm" action="{{ route('register.teacher.store') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <label for="name"
                                       class="control-label false-padding-bottom">Full
                                    Name <label class="text-danger">*</label></label>

                                <input id="name" type="text" class="form-control"
                                       name="name"
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
                        <div class="false-padding-bottom-form form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <label for="email"
                                       class="control-label false-padding-bottom">E-Mail
                                    Address<label
                                        class="text-danger">*</label></label>

                                <input id="email" type="email" class="form-control"
                                       name="email"
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
                        <div class="false-padding-bottom-form form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <label for="password"
                                       class="control-label false-padding-bottom">Password<label
                                        class="text-danger">*</label></label>
                                <input id="password" type="password"
                                       class="form-control" name="password"
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
                        <div class="false-padding-bottom-form form-group">

                            <div class="col-md-12">
                                <label for="password-confirm"
                                       class=" control-label false-padding-bottom">Confirm
                                    Password<label
                                        class="text-danger">*</label></label>

                                <input id="password-confirm" type="password"
                                       class="form-control"
                                       name="password_confirmation"
                                       required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('department') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <label for="department"
                                       class=" control-label false-padding-bottom">Department</label>

                                <select id="department" class="form-control"
                                        name="department_id"
                                        value="{{ old('department') }}"
                                        required>
                                    <option value="0">Select Department</option>
                                    @if (count($teacherDepartments) > 0)
                                        @foreach ($teacherDepartments as $d)
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
                                <label for="class_teacher"
                                       class=" control-label false-padding-bottom">Class
                                    Teacher</label>

                                <select id="class_teacher" class="form-control"
                                        name="class_teacher_section_id" value="{{ old('class_teacher') }}">
                                    <option selected="selected" value="0">Not Class
                                        Teacher
                                    </option>
                                    @foreach ($teacherSections as $section)
                                        <option value="{{$section->id}}">
                                            Section: {{$section->section_number}}
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <label for="phone_number"
                                       class="control-label false-padding-bottom">Phone
                                    Number<label class="text-danger">*</label></label>

                                <input id="phone_number" type="text"
                                       class="form-control" name="phone_number"
                                       value="{{ old('phone_number') }}" required>

                                @if ($errors->has('phone_number'))
                                    <span class="help-block">
                                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('blood_group') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <label for="blood_group"
                                       class=" control-label false-padding-bottom">Blood
                                    Group</label>

                                <select id="blood_group" class="form-control"
                                        name="blood_group"
                                        value="{{ old('blood_group') }}">
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
                        <div class="false-padding-bottom-form form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <label for="nationality"
                                       class="control-label false-padding-bottom">Nationality</label>

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
                                       class="control-label false-padding-bottom">Gender<label
                                        class="text-danger">*</label></label>

                                <select id="gender" class="form-control"
                                        name="gender" value="value="{{ old('gender') }}">
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
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label for="name"
                                       class="control-label false-padding-bottom">Address<label class="text-danger">*</label></label>
                                <input id="address" type="text" class="form-control"
                                       name="address"
                                       value="{{ old('address') }}"
                                       required>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('about') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <label for="email"
                                       class="control-label false-padding-bottom">About</label>

                                <input id="about" type="text" class="form-control"
                                       name="about"
                                       value="{{ old('about') }}">

                                @if ($errors->has('about'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">

                    <div class="col-md-12">
                        <label class="control-label">
                            Upload Profile Picture
                        </label>
                        <br>
                        <input type="file" id="picPath" name="teacher_pic">
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

@endsection

@push('customjs')
    <script>
        $(document).ready(function () {
            $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show');
            $('#tabMenu a[href="#{{ old('tabMain') }}"]').tab('show');

        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var idx = $(this).index('a[data-toggle="tab"]');
            $('#tab-' + idx).addClass('active');
        });
    </script>
@endpush
