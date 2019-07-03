@extends('layouts.student-app')

@section('title', 'Change Password')

@section('content')
<div class="mt-5 false-height">
    <div class="row d-flex justify-content-start align-self-start order-1 p-2">
        <div class="col-lg-12">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="breadcrumbs-area">
                <h3>
                    Change Password
                </h3>
                <ul>
                    <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                            Back &nbsp;&nbsp;|</a>
                        <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
                    </li>
                    <li>Change Password</li>
                </ul>
            </div>
            <div class="card height-auto">
                <!-- <div class="card-header">
                        <h5>Change Password</h5>
                    </div> -->
                    <div class="card-body">
                        <form class="new-added-form" method="POST" action="{{url('user/config/change_password')}}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-6 form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                    <label>Current Password</label>
                                    <input id="current-password" type="password" class="form-control" name="current-password" value="{{ old('current-password') }}" required>
                                    @if ($errors->has('current-password'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('current-password') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label>New Password</label>
                                    <input id="password" type="password" class="form-control" name="password"
                                           value="{{ old('password') }}" required>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 form-group">
                                    <label>Confirm New Password</label>
                                    <input id="password_confirm" type="password" class="form-control" name="password_confirm"
                                           value="{{ old('password_confirm') }}" required>
                                    @if ($errors->has('password_confirm'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('password_confirm') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-6 form-group mg-t-8">
                                <button type="submit" class="button1 ml-5 button1--white button1--animation">Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
