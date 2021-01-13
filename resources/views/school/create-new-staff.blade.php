@extends('layouts.student-app')

@section('title', 'Create Staff')

@section('content')
    <div class="dashboard-content-one" >
        <div class="breadcrumbs-area">
            <h3>
                <i class="fas fa-user-plus"></i>
                {{ __('text.add_staff') }}
            </h3>
            <ul>
                <li>
                    <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                        {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
                </li>
                <li>{{ __('text.add_staff') }}</li>
            </ul>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
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
        <div class="false-height">
            <div class="card mb-3">
                <div class="card-body">
                    <form class="new-added-form" method="POST" enctype="multipart/form-data"
                          id="registerForm" action="{{ route('register.staff.store') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                                    <div class="col-md-12">
                                        <label for="name"
                                               class="control-label false-padding-bottom">{{ __('text.Name') }}<label class="text-danger">*</label></label>
                                        <input id="name" type="text" class="form-control staff-name"
                                               name="name" value="{{ old('name') }}"
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
                                <div class="false-padding-bottom-form form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                    <div class="col-md-12">
                                        <label for="email"
                                               class="control-label false-padding-bottom">{{ __('text.email_username') }}<label
                                                class="text-danger">*</label></label>
                                        <a href="" class="btn btn-primary btn-sm email-enable-button float-right">Enable email</a>

                                        @php
                                            $code = auth()->user()->school_id . date('y') . substr(number_format(time() * mt_rand(), 0, '', ''), 0, 5)
                                        @endphp

                                        <input type="hidden" name="student_code" value="{{ $code }}">

                                        <input id="email" type="email" class="form-control staff-username"
                                               name="email" value="{{ old('email') }}"
                                                readonly>
                                        <div class="email-visible"></div>

                                        @if ($errors->has('email'))
                                            <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">

                                    <div class="col-md-12">
                                        <label for="phone_number"
                                               class="control-label false-padding-bottom">{{ __('text.phone_number') }}</label>
                                        <input id="phone_number" type="text"
                                               class="form-control" name="phone_number"
                                               value="{{ old('phone_number') }}" >

                                        @if ($errors->has('phone_number'))
                                            <span class="help-block">
                                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('designation') ? 'designation' : '' }}">
                                    <div class="col-md-12">
                                        <label for="designation"
                                               class="control-label false-padding-bottom">{{ __('text.designation') }}<label
                                                class="text-danger">*</label></label>
                                        <input id="designation" type="text"
                                               class="form-control" name="designation"
                                               value="{{ old('designation') }}" required>

                                        @if ($errors->has('designation'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('designation') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('gender') ? ' has-error' : '' }}">

                                    <div class="col-md-12">
                                        <label for="gender"
                                               class="control-label false-padding-bottom">{{ __('text.gender') }}<label
                                                class="text-danger">*</label></label>

                                        <select id="gender" class="form-control"
                                                name="gender">
                                            <option class="text-capitalize" value="male"
                                                    selected="selected">Male
                                            </option>
                                            <option class="text-capitalize" value="female">
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
                                <div class="false-padding-bottom-form form-group{{ $errors->has('blood_group') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="blood_group"
                                               class="control-label false-padding-bottom">{{ __('text.blood_group') }}<label
                                                class="text-danger">*</label></label>

                                        <select id="blood_group" class="form-control"
                                                name="blood_group">
                                            <option selected="selected">N/A</option>
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
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">

                                    <div class="col-md-12">
                                        <label for="nationality"
                                               class="control-label false-padding-bottom">{{ __('text.nationality') }}</label>

                                        <input id="nationality" type="text"
                                               class="form-control" name="nationality"
                                               value="{{ old('nationality') }}">

                                        @if ($errors->has('nationality'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('nationality') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                    <div class="col-md-12">
                                        <label for="name"
                                               class="control-label false-padding-bottom">{{ __('text.address') }}<label
                                                class="text-danger">*</label></label>
                                        <input id="address" type="text" class="form-control"
                                               name="address"
                                               value="{{ old('address') }}"
                                               required>

                                        @if ($errors->has('address'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="false-padding-bottom-form form-group{{ $errors->has('about') ? ' has-error' : '' }}">

                                    <div class="col-md-12">
                                        <label for="email"
                                               class="control-label false-padding-bottom">{{ __('text.about') }}</label>

                                        <input id="about" type="text" class="form-control"
                                               name="about"
                                               value="{{ old('about') }}">

                                        @if ($errors->has('about'))
                                            <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 mt-4">
                                    <label class="control-label">
                                        {{ __('text.upload_picture') }}
                                        <br>
                                        <input type="file" id="picPath" name="pic_path">
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-4">
                                <button type="submit" id="registerBtn"
                                        class="button button--save float-right">
                                    {{ __('text.register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('customjs')
    <script>
        $(document).ready(function() {

            $('.staff-name').focusout(function() {
                let inputName = $('.staff-name').val();
                if (inputName) {
                    let names = inputName.split(' ');

                    let code = {!! $code !!};

                    let lastName = names[names.length - 1] ? names[names.length - 1] : names[names.length - 2];

                    let username = lastName + code;

                    $('.staff-username').val(username.toLowerCase());

                }
            });

            $('.email-enable-button').click(function(event) {
                event.preventDefault();

                $('.staff-username').remove();
                $('.email-visible').html(`<input id="email" type="email" class="form-control student-email"
                           name="email" value="" placeholder="Enter email address"
                           required>`);
                $('.email-enable-button').remove();
            });

        });
    </script>
@endpush

