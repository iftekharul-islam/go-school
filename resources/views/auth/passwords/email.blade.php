@extends('layouts.student-app')

@section('title', 'Login')

@section('content')
<div class="height-auto false-height">
    <!-- <div class="card-header">
            <h1>Login</h1>
        </div> -->
    <div class="header__text-box effect5">
        <h1 class="heading1 mt-5">
            <!-- <span class="heading--main">Password Reset</span> -->
            <span class="heading1">Password Reset</span>
        </h1>
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-12 text-left mg-t-30 control-label">E-Mail Address</label>

                <div class="col-md-12">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                        required>

                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group justify-content-left">
                <div class="col-md-10">
                    <button type="submit" class="button button--text float-left text-uppercase mt-5">
                       <b> Send Password Reset Link </b>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
{{--<div class="container">--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-8 col-md-offset-2">--}}
{{--            <div class="panel panel-default">--}}
{{--                <div class="page-panel-title">Reset Password</div>--}}

{{--                <div class="panel-body">--}}
{{--                    @if (session('status'))--}}
{{--                        <div class="alert alert-success">--}}
{{--                            {{ session('status') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">--}}
{{--                        {{ csrf_field() }}--}}

{{--                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">--}}
{{--                            <label for="email" class="col-md-12 control-label">E-Mail Address</label>--}}

{{--                            <div class="col-md-12">--}}
{{--                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
required>--}}

{{--                                @if ($errors->has('email'))--}}
{{--                                    <span class="help-block">--}}
{{--                                        <strong>{{ $errors->first('email') }}</strong>--}}
{{--                                    </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <div class="col-md-6 col-md-offset-4">--}}
{{--                                <button type="submit" class="btn btn-primary">--}}
{{--                                    Send Password Reset Link--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--@endsection--}}
