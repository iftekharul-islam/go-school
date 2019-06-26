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
       <h3><a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; font-size: 22px;">Back</h4></a>&nbsp;&nbsp;Create Admin</h3>
       <ul style="margin-left: -100px !important;">
           <li>
               <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
           </li>
           <li>Create Admin</li>
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
                            <div class="col-lg-6 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label>Old Password</label>
                                <input id="old_password" type="password" class="form-control" name="old_password"
                                    value="{{ old('old_password') }}" required>
                                {{--                                    <input type="text" placeholder="" class="form-control" name="email" value="{{ old('email') }}">--}}
                                @if ($errors->has('old_password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('old_password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-lg-12 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label>New Password</label>
                                {{--                                    <input type="password" placeholder="" class="form-control" name="password" required>--}}
                                <input id="new_password" type="password" class="form-control" name="new_password"
                                    value="{{ old('new_password') }}" required>
                                @if ($errors->has('new_password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('new_password') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="button1 button1--white button1--animation float-left"
                                    style="margin-right: 2rem;">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
