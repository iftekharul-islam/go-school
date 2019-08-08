@extends('layouts.student-app')

@section('title', 'Manage Schools')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-cog fa-fw"></i>
            Academic Settings
        </h3>
        <ul>
            <li><a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Academic Settings</li>
        </ul>
    </div>

    <div class="card height-auto false-height aesteric">
        <div class="ui-tab-card">
            <div class="card-body">
                <div class="heading-layout1 mg-b-25">
                    <div class="item-title">
                        <h3>Manage School</h3>
                    </div>
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
                <div class="border-nav-tab border-0">
                    <ul class="nav nav-tabs" role="tablist" id="tabMenu">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-0" data-toggle="tab" href="#tab7" role="tab"
                               aria-selected="true">Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-1" data-toggle="tab" href="#tab8" role="tab"
                               aria-selected="false">Academics</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active border-0 academic-tab" id="tab7" role="tabpanel">
                            <div class="ui-tab-card">
                                <div class="ml-5 mr-5">
                                    <div class="heading-layout1 mg-b-25">
                                        <div class="item-title">
                                            <h3>Users</h3>
                                        </div>
                                    </div>
                                    <div class="basic-tab">
                                        <ul class="nav nav-tabs" id="tabMenu" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="tab-2" data-toggle="tab" href="#tab10"
                                                   role="tab" aria-selected="true">Add Accountant</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="tab-3" data-toggle="tab" href="#tab11"
                                                   role="tab" aria-selected="false">Add Librarian</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="tab-4" data-toggle="tab" href="#tab12"
                                                   role="tab" aria-selected="false">Add Student</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="tab-5" data-toggle="tab" href="#tab13"
                                                   role="tab" aria-selected="false">Add Teacher</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active border-0" id="tab10" role="tabpanel">
                                                <form enctype="multipart/form-data" class="new-added-form" method="POST" id="registerForm"
                                                      action="{{ url('admin/register/accountant') }}">
                                                    {{ csrf_field() }}
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                                <div class="col-md-12">
                                                                    <label for="name" class="control-label false-padding-bottom">Full Name <label class="text-danger">*</label></label>
                                                                    <input id="name" type="text" class="form-control"
                                                                           name="name"
                                                                           value=""
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
                                                                    <label for="email" class="control-label false-padding-bottom">E-Mail Address <label class="text-danger">*</label></label>

                                                                    <input id="email" type="email" class="form-control"
                                                                           name="email"
                                                                           value="" required>

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
                                                                    <label for="password" class="control-label false-padding-bottom">Password<label class="text-danger">*</label></label>
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
                                                            <div class="form-group false-padding-bottom-form">


                                                                <div class="col-md-12">
                                                                    <label for="password-confirm" class=" control-label false-padding-bottom">Confirm
                                                                        Password<label class="text-danger">*</label></label>
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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="phone_number" class=" control-label false-padding-bottom">Phone Number<label class="text-danger">*</label></label>

                                                                    <input id="phone_number" type="text"
                                                                           class="form-control" name="phone_number"
                                                                    >

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
                                                                    <label for="blood_group" class="control-label false-padding-bottom">Blood Group<label class="text-danger">*</label></label>

                                                                    <select id="blood_group" class="form-control"
                                                                            name="blood_group">
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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="nationality" class="control-label false-padding-bottom">Nationality<label class="text-danger">*</label></label>

                                                                    <input id="nationality" type="text"
                                                                           class="form-control" name="nationality"
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

                                                                <div class="col-md-12">
                                                                    <label for="gender" class="control-label">Gender<label class="text-danger">*</label></label>
                                                                    <select id="gender" class="form-control"
                                                                            name="gender">
                                                                        <option class="text-capitalize" value="male" selected="selected">Male</option>
                                                                        <option class="text-capitalize" value="female">Female</option>
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
                                                                    <label for="name" class="control-label false-padding-bottom">Address<label class="text-danger">*</label></label>
                                                                    <input id="address" type="text" class="form-control"
                                                                           name="address"
                                                                           value=""
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
                                                                    <label for="email" class="control-label false-padding-bottom">About<label class="text-danger">*</label></label>

                                                                    <input id="about" type="text" class="form-control"
                                                                           name="about"
                                                                           value="" required>

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
                                                            <label class="control-label false-padding-bottom">Upload Profile Picture</label>
                                                            <br>
                                                            <input type="file" id="picPath" name="pic_path">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-12 col-md-offset-4">
                                                            <button type="submit" id="registerBtn" class="button button--save float-right">
                                                                Register
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade border-0" id="tab11" role="tabpanel">
                                                <form class="new-added-form" method="POST" enctype="multipart/form-data" id="registerForm" action="{{ url('admin/register/librarian') }}">
                                                    {{ csrf_field() }}
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="name" class="control-label false-padding-bottom">Full Name<label class="text-danger">*</label></label>
                                                                    <input id="name" type="text" class="form-control"
                                                                           name="name"
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
                                                                    <label for="email" class="control-label false-padding-bottom">E-Mail Address<label class="text-danger">*</label></label>

                                                                    <input id="email" type="email" class="form-control"
                                                                           name="email"
                                                                           required>

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
                                                                    <label for="password" class="control-label false-padding-bottom">Password<label class="text-danger">*</label></label>

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
                                                                    <label for="password-confirm" class="control-label false-padding-bottom">Confirm
                                                                        Password<label class="text-danger">*</label></label>

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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="phone_number" class="control-label false-padding-bottom">Phone Number<label class="text-danger">*</label></label>
                                                                    <input id="phone_number" type="text"
                                                                           class="form-control" name="phone_number"
                                                                           value="">

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
                                                                    <label for="blood_group" class="control-label false-padding-bottom">Blood Group<label class="text-danger">*</label></label>

                                                                    <select id="blood_group" class="form-control"
                                                                            name="blood_group">
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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="nationality" class="control-label false-padding-bottom">Nationality<label class="text-danger">*</label></label>

                                                                    <input id="nationality" type="text"
                                                                           class="form-control" name="nationality"
                                                                           value=""
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
                                                                    <label for="gender" class="control-label false-padding-bottom">Gender<label class="text-danger">*</label></label>

                                                                    <select id="gender" class="form-control"
                                                                            name="gender">
                                                                        <option class="text-capitalize" value="male" selected="selected">Male</option>
                                                                        <option class="text-capitalize" value="female">Female</option>
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
                                                                    <label for="name" class="control-label false-padding-bottom">Address<label class="text-danger">*</label></label>
                                                                    <input id="address" type="text" class="form-control"
                                                                           name="address"
                                                                           value=""
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
                                                                    <label for="email" class="control-label false-padding-bottom">About<label class="text-danger">*</label></label>

                                                                    <input id="about" type="text" class="form-control"
                                                                           name="about"
                                                                           value="" required>

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
                                                            <label class="control-label">Upload Profile Picture</label>
                                                            <br>
                                                            <input type="file" id="picPath" name="pic_path">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-12 col-md-offset-4">
                                                            <button type="submit" id="registerBtn" class="button button--save float-right">
                                                                Register
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="tab-pane fade border-0" id="tab12" role="tabpanel">
                                                <form class="new-added-form" method="POST" id="registerForm"
                                                      enctype="multipart/form-data"
                                                      action="{{ url('admin/register/student') }}">
                                                    {{ csrf_field() }}
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="name" class="control-label false-padding-bottom">Full Name<label class="text-danger">*</label></label>
                                                                    <input id="na   me" type="text" class="form-control"
                                                                           name="name" value="" required>

                                                                    @if ($errors->has('name'))
                                                                        <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="email" class="control-label false-padding-bottom">E-Mail Address<label class="text-danger">*</label></label>

                                                                    <input id="email" type="email" class="form-control"
                                                                           name="email" value="{{ old('email') }}"
                                                                           required>

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
                                                                    <label for="password" class="control-label false-padding-bottom">Password<label class="text-danger">*</label></label>
                                                                    <input id="password" type="password"
                                                                           class="form-control" name="password"
                                                                           required>

                                                                    @if ($errors->has('password'))
                                                                        <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group">

                                                                <div class="col-md-12">
                                                                    <label for="password-confirm" class="control-label false-padding-bottom">Confirm Password<label class="text-danger">*</label></label>

                                                                    <input id="password-confirm" type="password"
                                                                           class="form-control"
                                                                           name="password_confirmation" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('section') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="section" class="control-label false-padding-bottom">Class and Section<label class="text-danger">*</label></label>

                                                                    <select id="section" class="form-control"
                                                                            name="section" required>
                                                                        @foreach ($studentSections as $section)
                                                                            <option value="{{$section->id}}">
                                                                                Section: {{$section->section_number}}
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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="birthday" class="control-label false-padding-bottom">Birthday<label class="text-danger">*</label></label>

                                                                    <input data-date-format="yyyy-mm-dd" id="birthday" class="form-control date" name="birthday" value="{{ old('birthday') }}" placeholder="Birthday" required autocomplete="off">

                                                                    @if ($errors->has('birthday'))
                                                                        <span class="help-block"><strong>{{ $errors->first('birthday') }}</strong></span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="phone_number" class="control-label false-padding-bottom">Phone Number<label class="text-danger">*</label></label>

                                                                    <input id="phone_number" type="text"
                                                                           class="form-control" name="phone_number"
                                                                           value="{{ old('phone_number') }}">

                                                                    @if ($errors->has('phone_number'))
                                                                        <span class="help-block"><strong>{{ $errors->first('phone_number') }}</strong></span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('blood_group') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="blood_group" class=" control-label false-padding-bottom">Blood Group<label class="text-danger">*</label></label>

                                                                    <select id="blood_group" class="form-control"
                                                                            name="blood_group">
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
                                                                        <span class="help-block"><strong>{{ $errors->first('blood_group') }}</strong></span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="nationality" class=" control-label false-padding-bottom">Nationality<label class="text-danger">*</label></label>

                                                                    <input id="nationality" type="text"
                                                                           class="form-control" name="nationality"
                                                                           value=""
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
                                                                    <label for="gender" class="control-label false-padding-bottom">Gender</label>

                                                                    <select id="gender" class="form-control"
                                                                            name="gender">
                                                                        <option class="text-capitalize" value="male" selected="selected">Male</option>
                                                                        <option class="text-capitalize" value="female">Female</option>
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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('version') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="version" class="control-label false-padding-bottom">Version<label class="text-danger">*</label></label>

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
                                                                    <label for="session" class="control-label false-padding-bottom">Session<label class="text-danger">*</label></label>

                                                                    <input id="session" type="text" class="form-control"
                                                                           name="session"
                                                                           value=""
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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('group') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="group" class=" control-label false-padding-bottom">Group (Optional)</label>

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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('religion') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="religion" class=" control-label false-padding-bottom">Religion<label class="text-danger">*</label></label>

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
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('address') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="address" class="control-label false-padding-bottom">Address<label class="text-danger">*</label></label>

                                                                    <input id="address" type="text" class="form-control"
                                                                           name="address"
                                                                           value=""
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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('about') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="about" class=" control-label false-padding-bottom">About</label>

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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('father_name') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="father_name" class=" control-label false-padding-bottom">Father's Name<label class="text-danger">*</label></label>

                                                                    <input id="father_name" type="text"
                                                                           class="form-control" name="father_name"
                                                                           value=""
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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('father_phone_number') ? ' has-error' : '' }}">


                                                                <div class="col-md-12">
                                                                    <label for="father_phone_number" class="control-label false-padding-bottom">Father's Phone
                                                                        Number<label class="text-danger">*</label></label>
                                                                    <input id="father_phone_number" type="text"
                                                                           class="form-control"
                                                                           name="father_phone_number"
                                                                           value="">

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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('father_national_id') ? ' has-error' : '' }}">


                                                                <div class="col-md-12">
                                                                    <label for="father_national_id" class="control-label false-padding-bottom">Father's National
                                                                        ID<label class="text-danger">*</label></label>
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
                                                                    <label for="father_occupation" class=" control-label false-padding-bottom">Father's
                                                                        Occupation</label>
                                                                    <input id="father_occupation" type="text"
                                                                           class="form-control"
                                                                           name="father_occupation">

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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('father_annual_income') ? ' has-error' : '' }}">


                                                                <div class="col-md-12">
                                                                    <label for="father_annual_income" class="control-label false-padding-bottom">Father's Annual
                                                                        Income</label>
                                                                    <input id="father_annual_income" type="text"
                                                                           class="form-control"
                                                                           name="father_annual_income">

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
                                                                    <label for="father_designation" class=" control-label false-padding-bottom">Father's
                                                                        Designation</label>

                                                                    <input id="father_designation" type="text"
                                                                           class="form-control"
                                                                           name="father_designation"
                                                                    >

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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('mother_phone_number') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="mother_phone_number" class="control-label false-padding-bottom">Mother's Phone
                                                                        Number</label>

                                                                    <input id="mother_phone_number" type="text"
                                                                           class="form-control"
                                                                           name="mother_phone_number"
                                                                    >

                                                                    @if ($errors->has('mother_phone_number'))
                                                                        <span class="help-block">
                                    <strong>{{ $errors->first('mother_phone_number') }}</strong>
                                </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('mother_name') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="mother_name" class=" control-label false-padding-bottom">Mother's Name<label class="text-danger">*</label></label>

                                                                    <input id="mother_name" type="text"
                                                                           class="form-control" name="mother_name"
                                                                           value=""
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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('mother_occupation') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="mother_occupation" class="control-label false-padding-bottom">Mother's
                                                                        Occupation</label>

                                                                    <input id="mother_occupation" type="text"
                                                                           class="form-control"
                                                                           name="mother_occupation"
                                                                           value="">

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
                                                                    <label for="mother_national_id" class=" control-label false-padding-bottom">Mother's National
                                                                        ID<label class="text-danger">*</label></label>

                                                                    <input id="mother_national_id" required type="text"
                                                                           class="form-control"
                                                                           name="mother_national_id"
                                                                           value="">

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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('mother_designation') ? ' has-error' : '' }}">


                                                                <div class="col-md-12">
                                                                    <label for="mother_designation" class="control-label false-padding-bottom">Mother's
                                                                        Designation</label>
                                                                    <input id="mother_designation" type="text"
                                                                           class="form-control"
                                                                           name="mother_designation"
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
                                                                    <label for="mother_annual_income" class=" control-label false-padding-bottom">Mother's Annual
                                                                        Income</label>
                                                                    <input id="mother_annual_income" type="text"
                                                                           class="form-control"
                                                                           name="mother_annual_income"
                                                                    >

                                                                    @if ($errors->has('mother_annual_income'))
                                                                        <span class="help-block">
                                    <strong>{{ $errors->first('mother_annual_income') }}</strong>
                                </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">

                                                        <div class="col-md-12">
                                                            <label class=" control-label">Upload Profile
                                                                Picture</label>
                                                            <input type="file" id="picPath" name="student_pic">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-12 col-md-offset-4">
                                                            <button type="submit" id="registerBtn" class="button button--save float-right">
                                                                Register
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="tab-pane fade border-0" id="tab13" role="tabpanel">
                                                <form class="new-added-form" method="POST" enctype="multipart/form-data" id="registerForm" action="{{ url('admin/register/teacher') }}">
                                                    {{ csrf_field() }}
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="name" class="control-label false-padding-bottom">Full Name<label class="text-danger">*</label></label>

                                                                    <input id="name" type="text" class="form-control"
                                                                           name="name"
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
                                                                    <label for="email" class="control-label false-padding-bottom">E-Mail Address<label class="text-danger">*</label></label>

                                                                    <input id="email" type="email" class="form-control"
                                                                           name="email"
                                                                           value="" required>

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
                                                                    <label for="password" class="control-label false-padding-bottom">Password<label class="text-danger">*</label></label>
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
                                                                    <label for="password-confirm" class=" control-label false-padding-bottom">Confirm
                                                                        Password<label class="text-danger">*</label></label>

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
                                                                    <label for="department" class=" control-label false-padding-bottom">Department<label class="text-danger">*</label></label>

                                                                    <select id="department" class="form-control"
                                                                            name="department_id" required>
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
                                                                    <label for="class_teacher" class=" control-label false-padding-bottom">Class Teacher</label>

                                                                    <select id="class_teacher" class="form-control"
                                                                            name="class_teacher_section_id">
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
                                                                    <label for="phone_number" class="control-label false-padding-bottom">Phone Number<label class="text-danger">*</label></label>

                                                                    <input id="phone_number" type="text"
                                                                           class="form-control" name="phone_number"
                                                                           value="">

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
                                                                    <label for="blood_group" class=" control-label false-padding-bottom">Blood Group<label class="text-danger">*</label></label>

                                                                    <select id="blood_group" class="form-control"
                                                                            name="blood_group">
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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="nationality" class="control-label false-padding-bottom">Nationality<label class="text-danger">*</label></label>

                                                                    <input id="nationality" type="text"
                                                                           class="form-control" name="nationality"
                                                                           value=""
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
                                                                    <label for="gender" class="control-label false-padding-bottom">Gender<label class="text-danger">*</label></label>

                                                                    <select id="gender" class="form-control"
                                                                            name="gender">
                                                                        <option class="text-capitalize" value="male" selected="selected">Male</option>
                                                                        <option class="text-capitalize" value="female">Female</option>
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
                                                                    <label for="name" class="control-label false-padding-bottom">Address<label class="text-danger">*</label></label>
                                                                    <input id="address" type="text" class="form-control"
                                                                           name="address"
                                                                           value=""
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
                                                                    <label for="email" class="control-label false-padding-bottom">About<label class="text-danger">*</label></label>

                                                                    <input id="about" type="text" class="form-control"
                                                                           name="about"
                                                                           value="" required>

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
                                                            <label class="control-label">Upload Profile Picture</label>
                                                            <br>
                                                            <input type="file" id="picPath" name="teacher_pic">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-12 col-md-offset-4">
                                                            <button type="submit" id="registerBtn" class="button button--save float-right">
                                                                Register
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab8" role="tabpanel">
                            <div class="ui-tab-card">
                                <div class="ml-5 mr-5">
                                    <div class="heading-layout1 mg-b-25">
                                        <div class="item-title align-center">
                                            <h3>Academic</h3>
                                        </div>
                                    </div>
                                    <div class="basic-tab">
                                        <ul class="nav nav-tabs" id="tabMenu" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="tab-6" data-toggle="tab" href="#tab1"
                                                   role="tab" aria-selected="true">Create Department</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="tab-7" data-toggle="tab" href="#tab2" role="tab"
                                                   aria-selected="false">Mange Classes</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active fade show border-0 academic-tab" id="tab1" role="tabpanel">
                                                <form class="new-added-form"
                                                      action="{{url('admin/school/add-department')}}"
                                                      method="post">
                                                    {{csrf_field()}}
                                                    <div class="false-padding-bottom-form form-group">
                                                        <label for="department_name" class="col-sm-12 control-label false-padding-bottom">Department Name<label class="text-danger">*</label></label>
                                                        <div class="col-sm-12">
                                                            <input type="text" required class="form-control" id="department_name"
                                                                   name="department_name"
                                                                   placeholder="English, Math,...">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10">
                                                            <button type="submit"
                                                                    class="button button--save float-left">
                                                                Submit
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane fade border-0" id="tab2" role="tabpanel">
                                                @foreach($schools as $school)
                                                    @if(\Auth::user()->role == 'master' || \Auth::user()->school_id == $school->id)
                                                        @if(\Auth::user()->school_id == $school->id)
                                                            <tr class="collapse" id="collapse{{($loop->index + 1)}}"
                                                                aria-labelledby="heading{{($loop->index + 1)}}"
                                                                aria-expanded="false">
                                                                <td colspan="12">
                                                                    @include('layouts.master.add-class-form')
                                                                    <div>
                                                                        <small>Click Class to View All Sections</small>
                                                                    </div>
                                                                    <div class="row">
                                                                        @foreach($classes as $class)
                                                                            @if($class->school_id == $school->id)
                                                                                <div class="col-sm-3">
                                                                                    <button type="button"
                                                                                            class="button button--save float-left"
                                                                                            data-toggle="modal"
                                                                                            data-target="#myModal{{$class->id}}"
                                                                                            style="margin-top: 5%;">
                                                                                        Manage Class
                                                                                        : {{$class->class_number}} {{!empty($class->group)? '- '.$class->group:''}}</button>
                                                                                    <!-- Modal -->
                                                                                    <div class="modal fade"
                                                                                         id="myModal{{$class->id}}"
                                                                                         tabindex="-1" role="dialog"
                                                                                         aria-labelledby="myModalLabel">
                                                                                        <div class="modal-dialog modal-lg"
                                                                                             role="document">
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <h4 class="modal-title"
                                                                                                        id="myModalLabel">
                                                                                                        All
                                                                                                        Sections of
                                                                                                        Class {{$class->class_number}}</h4>
                                                                                                    <button type="button"
                                                                                                            class="close"
                                                                                                            data-dismiss="modal"
                                                                                                            aria-label="Close">
                                                                                                        <span aria-hidden="true">&times;</span>
                                                                                                    </button>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <ul class="list-group">
                                                                                                        @foreach($sections as $section)
                                                                                                            @if($section->class_id == $class->id)
                                                                                                                <li class="list-group-item">
                                                                                                                    Section {{$section->section_number}}
                                                                                                                    &nbsp;
                                                                                                                    <a class="btn btn-lg btn-warning"
                                                                                                                       href="{{url('admin/courses/0/'.$section->id)}}">View
                                                                                                                        All
                                                                                                                        Assigned
                                                                                                                        Courses</a>
                                                                                                                    <span class="pull-right"> &nbsp;&nbsp;
                                                                                                                <a class="btn btn-lg btn-success mr-2"
                                                                                                                   href="{{url('admin/school/promote-students/'.$section->id)}}">+ Promote Students</a></span>
                                                                                                                    @include('layouts.master.add-course-form')
                                                                                                                </li>
                                                                                                            @endif
                                                                                                        @endforeach
                                                                                                    </ul>
                                                                                                    @include('layouts.master.create-section-form')
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <button type="button"
                                                                                                            class="button button--cancel"
                                                                                                            data-dismiss="modal">
                                                                                                        Close
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('.date').datepicker({
                format: 'yyyy-mm-dd',
                language: 'en'
            });
        })
    </script>

    <script>

        $(document).ready(function () {
            $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show')
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var idx = $(this).index('a[data-toggle="tab"]');
            console.log(idx);
            $('#tab-' + idx).addClass('active');
        });
    </script>
@endsection
