@extends('layouts.student-app')

@section('title', 'Edit')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.edit') }}
        </h3>
        <ul>
            <li><a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }} </a>|
                <a class="text-color" href="{{ url( current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.edit') }}</li>
        </ul>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="col-md-{{ (\Auth::user()->role == 'master')? 12 : 12 }}" id="main-container">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <form class="new-added-form" method="POST" action="{{ route('edit.user') }}"
                              enctype='multipart/form-data'>
                            {{ csrf_field() }}
                            {{ method_field('patch') }}
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <input type="hidden" name="user_role" value="{{$user->role}}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div
                                        class="false-padding-bottom-form form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="name" class="control-label false-padding-bottom">{{ __('text.Name') }}
                                                <label class="text-danger">*</label></label>
                                            <input id="name" type="text" class="form-control" name="name"
                                                   value="{{ $user->name }}"
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

                                        <div class="col-md-12">
                                            <label for="email" class="control-label false-padding-bottom">{{ __('text.userType') }}
                                                <label class="text-danger">*</label></label>
                                            <input id="email" type="text" class="form-control" name="email"
                                                   value="{{ $user->email }}">

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div
                                        class="false-padding-bottom-form form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="phone_number" class="control-label false-padding-bottom">{{ __('text.phone_number') }}</label>
                                            <input id="phone_number" type="text" class="form-control"
                                                   name="phone_number"
                                                   value="{{ $user->phone_number }}">

                                            @if ($errors->has('phone_number'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-md-6">
                                        <div
                                            class="false-padding-bottom-form form-group{{ $errors->has('address') ? ' has-error' : '' }}">

                                            <div class="col-md-12">
                                                <label for="address"
                                                       class="control-label false-padding-bottom">{{ __('text.address') }}<label
                                                        class="text-danger">*</label></label>
                                                <input id="address" type="text" class="form-control" name="address"
                                                       value="{{ $user->address }}" required>

                                                @if ($errors->has('address'))
                                                    <span class="help-block">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                <div class="col-md-6">
                                    <div
                                        class="false-padding-bottom-form form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="nationality" class="control-label false-padding-bottom">{{ __('text.nationality') }}</label>
                                            <input id="nationality" type="text" class="form-control" name="nationality"
                                                   value="{{ $user->nationality }}">

                                            @if ($errors->has('nationality'))
                                                <span class="help-block">
                                    <strong>{{ $errors->first('nationality') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div
                                        class="false-padding-bottom-form form-group{{ $errors->has('gender') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="gender" class="control-label false-padding-bottom">{{ __('text.gender') }}<label
                                                    class="text-danger">*</label></label>
                                            <select id="gender" class="form-control" name="gender">
                                                <option @if($user->gender == 'Male') selected="selected" @endif>Male
                                                </option>
                                                <option @if($user->gender == 'Female') selected="selected" @endif>
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
                                <div class="col-md-6">
                                    <div
                                        class="false-padding-bottom-form form-group{{ $errors->has('blood_group') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="blood_group" class="control-label false-padding-bottom">{{ __('text.blood_group') }}</label>
                                            <select id="blood_group" class="form-control" name="blood_group">
                                                <option @if($user->blood_group == 'N/A') selected="selected"
                                                        @endif value="N/A">N/A
                                                </option>
                                                <option @if($user->blood_group == 'A+') selected="selected"
                                                        @endif value="A+">A+
                                                </option>
                                                <option @if($user->blood_group == 'A-') selected="selected"
                                                        @endif value="A-">A-
                                                </option>
                                                <option @if($user->blood_group == 'B+') selected="selected"
                                                        @endif value="B+">B+
                                                </option>
                                                <option @if($user->blood_group == 'B-') selected="selected"
                                                        @endif value="B-">B-
                                                </option>
                                                <option @if($user->blood_group == 'AB+') selected="selected"
                                                        @endif value="AB+">AB+
                                                </option>
                                                <option @if($user->blood_group == 'AB-') selected="selected"
                                                        @endif value="AB-">AB-
                                                </option>
                                                <option @if($user->blood_group == 'O+') selected="selected"
                                                        @endif value="O+">O+
                                                </option>
                                                <option @if($user->blood_group == 'O-') selected="selected"
                                                        @endif value="O-">O-
                                                </option>
                                            </select>

                                            @if ($errors->has('blood_group'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('blood_group') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div
                                        class="false-padding-bottom-form form-group{{ $errors->has('about') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <label for="about" class="control-label false-padding-bottom">{{ __('text.about') }}</label>
                                            <textarea id="about" class="form-control"
                                                      name="about">{{ $user->about }}</textarea>

                                            @if ($errors->has('about'))
                                                <span class="help-block">
                                    <strong>{{ $errors->first('about') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <div class="col-md-12">
                                            <label class="control-label">{{ __('text.upload_picture') }}</label>
                                            <br>
                                            <input type="file" id="pic_path" name="pic_path"
                                                   value="{{ $user->pic_path }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12 text-right form">
                                    <a href="{{ URL::previous() }}" class="button button--cancel mr-2"
                                       role="button">{{ __('text.Cancel') }}</a>
                                    <button type="submit" role="button" class="button button--save">{{ __('text.save') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
