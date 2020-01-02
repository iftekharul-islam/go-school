@extends('layouts.student-app')

@section('title', 'Register Librarian')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            </a>Create Librarian
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Create Librarian</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
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
