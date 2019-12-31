@extends('layouts.student-app')

@section('title', 'Create Librarian')

@section('content')
    <div class="dashboard-content-one" >
        <div class="breadcrumbs-area">
            <h3>
                <i class="fas fa-user-plus"></i>
                Add Librarian
            </h3>
            <ul>
                <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                        Back &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li>Add Librarian</li>
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
            <div class="card mb-3">
                <div class="card-body">
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
                                    <br>
                                    <input type="file" id="picPath" name="pic_path">
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

