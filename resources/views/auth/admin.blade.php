@extends('layouts.student-app')

@section('title', 'Register Admin')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Create Admin
        </h3>
        <ul>
            <li><a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Create Admin</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3></h3>
                </div>
            </div>
            <div class="col-md-12" id="main-container">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                        @if (session('register_school_id'))
                            <a href="{{ url('school/admin-list/' . session('register_school_id')) }}"
                               target="_blank" class="text-primary pull-right ml-5">View Admins</a>
                        @endif
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
            </div>
            <div class="">
                <div class="">
                    <form class="new-added-form" enctype="multipart/form-data" method="POST" id="registerForm"
                          action="{{ url('master/register/admin') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="school_id" value="{{ $id }}">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Full Name</label>

                                    <div class="col-md-12">
                                        <input id="name" type="text" class="form-control" name="name"
                                               value="{{ old('name') }}" required>

                                        @if ($errors->has('name'))
                                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
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
                        <div class="row mb-3">
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
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                    <label for="phone_number" class="col-md-4 control-label">Phone Number</label>

                                    <div class="col-md-12">
                                        <input id="phone_number" type="text" class="form-control" name="phone_number"
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
                        <div class="row mb-3">
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
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                    <label for="address" class="col-md-6 control-label">Address</label>

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
                                    <label for="about" class="col-md-6 control-label">About</label>

                                    <div class="col-md-12">
                                        <textarea id="about" class="form-control" name="about"
                                                  value="{{ old('about') }}"
                                                  required></textarea>

                                        @if ($errors->has('about'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('about') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('departments') ? ' has-error' : '' }}">
                                    <label for="departments" class="col-md-6 control-label">Departments</label>

                                    <div class="col-md-12">
                                        <select class="form-control select2" name="departments[]" id="departments" multiple>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('departments'))
                                            <span class="help-block">
                                    <strong class="text-danger">{{ $errors->first('departments') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Upload Profile Picture</label>
                            <div class="col-md-12">
                                <input type="file" required id="picPath" name="pic_path">
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
        @push('customjs')
            <script type="text/javascript">
                $(.'select2-multi').select2({
                    multiple:true
                });

            </script>
            @endpush
    </div>
@endsection