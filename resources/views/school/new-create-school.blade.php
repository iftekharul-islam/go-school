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
                                                <form enctype="multipart/form-data" class="new-added-form" method="POST"
                                                      id="registerForm"
                                                      action="{{ url('admin/register/accountant') }}">
                                                    {{ csrf_field() }}
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                                <div class="col-md-12">
                                                                    <label for="name"
                                                                           class="control-label false-padding-bottom">Full
                                                                        Name <label
                                                                                class="text-danger">*</label></label>
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
                                                                    <label for="email"
                                                                           class="control-label false-padding-bottom">E-Mail
                                                                        Address <label
                                                                                class="text-danger">*</label></label>

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
                                                            <div class="form-group false-padding-bottom-form">


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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="phone_number"
                                                                           class=" control-label false-padding-bottom">Phone
                                                                        Number<label
                                                                                class="text-danger">*</label></label>

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
                                                                    <label for="blood_group"
                                                                           class="control-label false-padding-bottom">Blood
                                                                        Group<label
                                                                                class="text-danger">*</label></label>

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
                                                                    <label for="nationality"
                                                                           class="control-label false-padding-bottom">Nationality<label
                                                                                class="text-danger">*</label></label>

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
                                                                    <label for="gender"
                                                                           class="control-label">Gender<label
                                                                                class="text-danger">*</label></label>
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
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                                                <div class="col-md-12">
                                                                    <label for="name"
                                                                           class="control-label false-padding-bottom">Address<label
                                                                                class="text-danger">*</label></label>
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
                                                                    <label for="email"
                                                                           class="control-label false-padding-bottom">About<label
                                                                                class="text-danger">*</label></label>

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
                                                            <label class="control-label false-padding-bottom">
                                                                Upload Profile Picture
                                                                <label class="text-danger">*</label>
                                                            </label>
                                                            <br>
                                                            <input type="file" required id="picPath" name="pic_path">
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
                                            <div class="tab-pane fade border-0" id="tab11" role="tabpanel">
                                                <form class="new-added-form" method="POST" enctype="multipart/form-data"
                                                      id="registerForm" action="{{ url('admin/register/librarian') }}">
                                                    {{ csrf_field() }}
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="name"
                                                                           class="control-label false-padding-bottom">Full
                                                                        Name<label class="text-danger">*</label></label>
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
                                                                    <label for="email"
                                                                           class="control-label false-padding-bottom">E-Mail
                                                                        Address<label
                                                                                class="text-danger">*</label></label>

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
                                                                           class="control-label false-padding-bottom">Confirm
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
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="phone_number"
                                                                           class="control-label false-padding-bottom">Phone
                                                                        Number<label
                                                                                class="text-danger">*</label></label>
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
                                                                    <label for="blood_group"
                                                                           class="control-label false-padding-bottom">Blood
                                                                        Group<label
                                                                                class="text-danger">*</label></label>

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
                                                                    <label for="nationality"
                                                                           class="control-label false-padding-bottom">Nationality<label
                                                                                class="text-danger">*</label></label>

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
                                                                    <label for="gender"
                                                                           class="control-label false-padding-bottom">Gender<label
                                                                                class="text-danger">*</label></label>

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
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                                                <div class="col-md-12">
                                                                    <label for="name"
                                                                           class="control-label false-padding-bottom">Address<label
                                                                                class="text-danger">*</label></label>
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
                                                                    <label for="email"
                                                                           class="control-label false-padding-bottom">About<label
                                                                                class="text-danger">*</label></label>

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
                                                            <label class="control-label">
                                                                Upload Profile Picture
                                                                <label class="text-danger">*</label>
                                                            </label>
                                                            <br>
                                                            <input type="file" required id="picPath" name="pic_path">
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

                                            <div class="tab-pane fade border-0" id="tab12" role="tabpanel">
                                                @include('school.create-new-student')
                                            </div>

                                            <div class="tab-pane fade border-0" id="tab13" role="tabpanel">
                                                <form class="new-added-form" method="POST" enctype="multipart/form-data"
                                                      id="registerForm" action="{{ url('admin/register/teacher') }}">
                                                    {{ csrf_field() }}
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                                                <div class="col-md-12">
                                                                    <label for="name"
                                                                           class="control-label false-padding-bottom">Full
                                                                        Name<label class="text-danger">*</label></label>

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
                                                                    <label for="email"
                                                                           class="control-label false-padding-bottom">E-Mail
                                                                        Address<label
                                                                                class="text-danger">*</label></label>

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
                                                                           class=" control-label false-padding-bottom">Department<label
                                                                                class="text-danger">*</label></label>

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
                                                                    <label for="class_teacher"
                                                                           class=" control-label false-padding-bottom">Class
                                                                        Teacher</label>

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
                                                                    <label for="phone_number"
                                                                           class="control-label false-padding-bottom">Phone
                                                                        Number<label
                                                                                class="text-danger">*</label></label>

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
                                                                    <label for="blood_group"
                                                                           class=" control-label false-padding-bottom">Blood
                                                                        Group<label
                                                                                class="text-danger">*</label></label>

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
                                                                    <label for="nationality"
                                                                           class="control-label false-padding-bottom">Nationality<label
                                                                                class="text-danger">*</label></label>

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
                                                                    <label for="gender"
                                                                           class="control-label false-padding-bottom">Gender<label
                                                                                class="text-danger">*</label></label>

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
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="false-padding-bottom-form form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                                                <div class="col-md-12">
                                                                    <label for="name"
                                                                           class="control-label false-padding-bottom">Address<label
                                                                                class="text-danger">*</label></label>
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
                                                                    <label for="email"
                                                                           class="control-label false-padding-bottom">About<label
                                                                                class="text-danger">*</label></label>

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
                                                            <label class="control-label">
                                                                Upload Profile Picture
                                                                <label class="text-danger">*</label>
                                                            </label>
                                                            <br>
                                                            <input type="file" required id="picPath" name="teacher_pic">
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
                                            <div class="tab-pane active fade show border-0 academic-tab" id="tab1"
                                                 role="tabpanel">
                                                <form class="new-added-form"
                                                      action="{{url('admin/school/add-department')}}"
                                                      method="post">
                                                    {{csrf_field()}}
                                                    <div class="false-padding-bottom-form form-group">
                                                        <label for="department_name"
                                                               class="col-sm-12 control-label false-padding-bottom">Department
                                                            Name<label class="text-danger">*</label></label>
                                                        <div class="col-sm-12">
                                                            <input type="text" required class="form-control"
                                                                   id="department_name"
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
                                                @include('school.new-manage-classes')
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



@endsection

@push('customjs')
    <script>
        $(document).ready(function () {
            $('#tabMenu a[href="#{{ old('tab') }}"]').tab('show')
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var idx = $(this).index('a[data-toggle="tab"]');
            $('#tab-' + idx).addClass('active');
        });
    </script>
@endpush
