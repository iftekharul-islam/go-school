@extends('layouts.student-app')

@section('title', 'Edit Information')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.edit') }}
        </h3>
        <ul>
            <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }}</a>|
                <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.edit') }}</li>
        </ul>
    </div>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
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
    <div class="card">
        <div class="card-body">
            <form class="new-added-form" method="POST" enctype="multipart/form-data" action="{{ route('update-staff-information', $user->id) }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="row mb-5">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">{{ __('text.Name') }}</label>
                            <input class="form-control" name="name" value="{{ $user->name }}">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label for="gender" class="control-label false-padding-bottom">{{ __('text.gender') }}</label>
                            <select id="gender" class="form-control" name="gender">
                                <option class="text-capitalize" value="male" selected="selected">Male</option>
                                <option class="text-capitalize" value="female">Female</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('blood_group') ? ' has-error' : '' }}">
                            <label for="blood_group">{{ __('text.blood_group') }}</label>
                            <select id="blood_group" class="form-control" name="blood_group">
                                <option selected="selected">{{ $user->blood_group }}</option>
                                <option>A+</option>
                                <option>A-</option>
                                <option>B+</option>
                                <option>B-</option>
                                <option>AB+</option>
                                <option>AB-</option>
                                <option>O+</option>
                                <option>O-</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('religion') ? ' has-error' : '' }}">
                            <label for="religion">{{ __('text.religion') }}</label>
                            <select id="religion" class="form-control" name="religion">
                                <option selected="selected">Islam</option>
                                <option>Hinduism</option>
                                <option>Christianism</option>
                                <option>Buddhism</option>
                                <option>Other</option>
                            </select>

                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="name">{{ __('text.address') }}</label>
                            <textarea class="form-control" name="address" value="{{ $user->address }}">{{ $user->address }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group {{ $errors->has('about') ? ' has-error' : '' }}">
                            <label for="name">{{ __('text.about') }}</label>
                            <textarea class="form-control" name="about" value="{{ $user->about }}">{{ $user->about }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="picPath" class="control-label mr-2">{{ __('text.upload_picture') }}</label>
                            <input type="file" id="picPath" name="pic_path">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <button type="submit" id="registerBtn" class="button button--save float-right">Update Information</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
