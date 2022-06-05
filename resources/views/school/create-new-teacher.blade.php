@extends('layouts.student-app')

@section('title', 'Create Teacher')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-user-plus"></i>
            {{ __('text.Add Teacher') }}
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.Add Teacher') }}</li>
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
    <div class="card height-auto mb-5">
        
        <div class="card-body">
            <form class="new-added-form" method="POST" enctype="multipart/form-data"
                  id="registerForm" action="{{ route('register.teacher.store') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                            <div class="col-md-12">
                                <label for="name"
                                       class="control-label false-padding-bottom">{{ __('text.Name') }}
                                    <label class="text-danger">*</label></label>

                                <input id="name" type="text" class="form-control teacher-name"
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
                                       class="control-label false-padding-bottom">{{ __('text.Email') }}
                                    <label
                                        class="text-danger">*</label></label>
                                <a href="" class="btn btn-primary email-enable-button float-right">Enable email</a>

                                @php
                                    $code = auth()->user()->school_id . date('y') . substr(number_format(time() * mt_rand(), 0, '', ''), 0, 5)
                                @endphp

                                <input id="email" type="email" class="form-control teacher-username"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required readonly>
                                <div class="email-visible"></div>

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
                                       class="control-label false-padding-bottom">{{ __('text.Password') }}
                                    <label class="text-danger">*</label></label>
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
                                       class=" control-label false-padding-bottom">{{ __('text.confirm_password') }}
                                    <label class="text-danger">*</label></label>

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
                                       class=" control-label false-padding-bottom">{{ __('text.Department') }}</label>

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
                                       class=" control-label false-padding-bottom">{{ __('text.class_teacher') }}</label>

                                <select id="class_teacher" class="form-control"
                                        name="class_teacher_section_id" value="{{ old('class_teacher') }}">
                                    <option selected="selected" value="0">Not Class
                                        Teacher
                                    </option>
                                    @foreach ($teacherSections as $section)
                                        <option value="{{$section->id}}">
                                            Class:
                                            {{$section->class->class_number}} Section: {{$section->section_number}}
                                            </option>
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
                                       class="control-label false-padding-bottom">{{ __('text.phone_number') }}<label class="text-danger">*</label></label>

                                <input id="phone_number" type="number"
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
                                       class=" control-label false-padding-bottom">{{ __('text.blood_group') }}</label>

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
                                       class="control-label false-padding-bottom">{{ __('text.nationality') }}</label>

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
                                       class="control-label false-padding-bottom">{{ __('text.gender') }}<label
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
                                       class="control-label false-padding-bottom">{{ __('text.address') }}<label class="text-danger">*</label></label>
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
                                       class="control-label false-padding-bottom">{{ __('text.about') }}</label>

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
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="false-padding-bottom-form form-group{{ $errors->has('teacher_pic') ? ' has-error' : '' }}">
                                <label class="control-label">
                                    {{ __('text.upload_picture') }}
                                </label>
                                <br>
                                <input type="file" id="picPath" name="teacher_pic">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="false-padding-bottom-form form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <div class="col-md-12">
                                <label class="control-label">
                                    {{ __('text.Shift') }} <label class="text-danger">*</label>
                                </label>
                                <br>
                                <select name="shift_id" class="form-control" required>
                                    <option value="" disabled selected>Select Shift</option>
                                    @if( count($shifts) > 0 )
                                        @foreach ($shifts as $shift)
                                            <option value="{{$shift->id}}" @if(old('shift_id') == $shift->id) selected @endif >{{ $shift->shift }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('shift_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('shift_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 col-md-offset-4">
                        <button type="submit" id="registerBtn"
                                class="button button--save float-right">
                            {{ __('text.register') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('customjs')
    <script>
        $(document).ready(function() {

            $('.teacher-name').focusout(function() {
                let inputName = $('.teacher-name').val();

                if (inputName) {
                    let names = inputName.split(' ');


                    let code = {!! $code !!};

                    let lastName = names[names.length - 1] ? names[names.length - 1] : names[names.length - 2];

                    let username = lastName + code;

                    $('.teacher-username').val(username.toLowerCase());
                }
            });
            $('.email-enable-button').click(function(event) {
                event.preventDefault();
                $('.teacher-username').remove();
                $('.email-visible').html(`<input id="email" type="email" class="form-control teacher-email"
                           name="email" value="" placeholder="Enter email address"
                           required>`);
                $('.email-enable-button').remove();
            });
        });
    </script>
@endpush
