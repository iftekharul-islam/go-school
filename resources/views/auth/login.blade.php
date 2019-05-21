@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container mt-5">
            <div class="row justify-content-md-center">
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
                    <div class="card height-auto false-height">
                        <div class="card-header">
                            <h1>Login</h1>
                        </div>
                        <div class="card-body">
                            <form class="new-added-form" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-12 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label>Email Address</label>
                                        <input type="text" placeholder="" class="form-control" name="email" value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-lg-12 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <label>Password</label>
                                        <input type="password" placeholder="" class="form-control" name="password" required>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-12 form-group mg-t-8">
                                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark" style="margin-right: 2rem;">Login</button>
                                        <a class="btn-fill-lg bg-blue-dark btn-hover-yellow" style="text-decoration:none !important;" href="{{ route('password.request') }}">Forgot Your Password?</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</div>

@endsection
