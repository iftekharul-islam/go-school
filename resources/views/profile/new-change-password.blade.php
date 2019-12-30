@extends('layouts.student-app')

@section('title', 'Change Password')

@section('content')
    <div class="false-height">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-area">
                    <h3>
                        Change Password
                    </h3>
                    <ul>
                        <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                                Back &nbsp;&nbsp;|</a>
                            <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                        </li>
                        <li>Change Password</li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error-status'))
                            <div class="alert alert-danger">
                                {{ session('error-status') }}
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
                        <div class="card height-auto false-height">
                            <div class="card-body">
                                <form class="new-added-form" method="POST" action="{{url('user/config/change_password')}}">
                                    {{ csrf_field() }}
                                    <div class="row mt-5">
                                        <div class="col-lg-12 form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                            <label>Current Password</label>
                                            <input id="current-password" type="password" class="form-control"
                                                   name="current-password" value="{{ old('current-password') }}"
                                                   required>
                                            @if ($errors->has('current-password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('current-password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-lg-12 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
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
                                    <div class="row mt-5">
                                        <div class="col-lg-12 form-group">
                                            <label>Confirm New Password</label>
                                            <input id="password_confirm" type="password" class="form-control"
                                                   name="password_confirm"
                                                   value="{{ old('password_confirm') }}" required>
                                            @if ($errors->has('password_confirm'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password_confirm') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group mg-t-20">
                                        <button type="submit" class="button button--text mr-5 mt-4">Change Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
