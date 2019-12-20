@extends('layouts.student-app')

@section('title', 'Edit Admin')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Edit Admin
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Edit Admin</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3></h3>
                </div>
            </div>
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
            <div class="">
                <div class="">
                    <form class="new-added-form" method="POST" enctype="multipart/form-data" id="registerForm" action="{{ url('master/edit/admin') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <input type="hidden" name="user_role" value="{{$user->role}}">
                        <div class="row mb-3">
                            <div class="col-md-10 col-lg-6">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Full Name</label>

                                    <div>
                                        <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required>

                                        @if ($errors->has('name'))
                                            <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10 col-lg-6">
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">E-Mail Address</label>

                                    <div>
                                        <input id="email" type="email" class="form-control" name="email"
                                               value="{{ $user->email }}" required>

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
                            <div class="col-md-10 col-lg-6">
                                <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                    <label for="phone_number">Phone Number</label>

                                    <div class="">
                                        <input id="phone_number" type="text" class="form-control" name="phone_number"
                                               value="{{ $user->phone_number }}" required>

                                        @if ($errors->has('phone_number'))
                                            <span class="help-block">
                                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10 col-lg-6">
                                <div class="form-group{{ $errors->has('blood_group') ? ' has-error' : '' }}">
                                    <label for="blood_group">Blood Group</label>

                                    <div class="">
                                        <select id="blood_group" class="form-control" name="blood_group">
                                            <option selected="{{$user->blood_group}}">{{$user->blood_group}}</option>
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
                        <div class="row mb-3">
                            <div class="col-md-10 col-lg-6">
                                <div class="form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">
                                    <label for="nationality">Nationality</label>

                                    <div class="">
                                        <input id="nationality" type="text" class="form-control" name="nationality"
                                               value="{{ $user->nationality }}"
                                               required>

                                        @if ($errors->has('nationality'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('nationality') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10 col-lg-6">
                                <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                    <label for="gender" class="">Gender</label>

                                    <div class="">
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
                            <div class="col-md-10 col-lg-6">
                                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                    <label for="address">Address</label>

                                    <div class="">
                                        <input id="address" type="text" class="form-control" name="address"
                                               value="{{ $user->address }}"
                                               required>

                                        @if ($errors->has('address'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10 col-lg-6">
                                <div class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">
                                    <label for="about">About</label>

                                    <div class="">
                                        <textarea id="about" class="form-control" name="about"
                                                  value=""
                                                  required>{{ $user->about }}</textarea>

                                        @if ($errors->has('about'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('about') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-10 col-lg-6">
                                <div class="form-group{{ $errors->has('departments') ? ' has-error' : '' }}">
                                    <label for="departments">Departments</label>

                                    <div class="">
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
                            <label>Upload Profile Picture</label>
                            <div>
                                <input type="file"   id="picPath" name="pic_path">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-4">
                                <button type="submit" id="registerBtn" class="button button--save float-right">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
