@extends('layouts.student-app')

@section('title', 'Create School')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Create School
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Create School</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="card height-auto false-height">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ url('master/create-school') }}">
                                {{ csrf_field() }}
                                <div class="mb-4 form-group{{ $errors->has('school_name') ? ' has-error' : '' }}">
                                    <label for="school_name" class="control-label">School Name <label class="text-danger">*</label></label>

                                    <input id="school_name" type="text" class="form-control" name="school_name" value="{{ old('school_name') }}" placeholder="School Name" required>

                                    @if ($errors->has('school_name'))
                                        <span class="help-block"><strong>{{ $errors->first('school_name') }}</strong></span>
                                    @endif
                                </div>
                                <div class="mb-4 form-group{{ $errors->has('school_medium') ? ' has-error' : '' }}">
                                    <label for="school_medium" class="control-label">School Medium <label class="text-danger">*</label></label>

                                    <select id="school_medium" class="select2" name="school_medium">
                                        <option selected="selected">Bangla</option>
                                        <option>English</option>
                                        <option>Bangla & English</option>
                                    </select>

                                    @if ($errors->has('school_medium'))
                                        <span class="help-block"><strong>{{ $errors->first('school_medium') }}</strong></span>
                                    @endif
                                </div>
                                <div class="mb-4 form-group{{ $errors->has('school_established') ? ' has-error' : '' }}">
                                    <label for="school_established" class="control-label">School Established <label class="text-danger">*</label></label>
                                    <input readonly="readonly" data-date-format="yyyy-mm-dd" id="birthday"
                                           class="form-control date" name="school_established"
                                           placeholder="School Established" required
                                           autocomplete="off">
                                    @if ($errors->has('school_established'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('school_established') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="mb-4 form-group{{ $errors->has('school_about') ? ' has-error' : '' }}">
                                    <label for="school_about" class="control-label">About <label class="text-danger">*</label></label>

                                    <textarea id="school_about" class="form-control" rows="3" name="school_about"
                                              placeholder="About School" required>{{ old('school_about') }}</textarea>

                                    @if ($errors->has('school_about'))
                                        <span class="help-block"><strong>{{ $errors->first('school_about') }}</strong></span>
                                    @endif
                                </div>
                                <div class="mb-4 form-group{{ $errors->has('district') ? ' has-error' : '' }}">
                                    <label for="district" class="control-label">District <label class="text-danger">*</label></label>
                                    <select id="district" class="form-control select2" name="district" required>
                                        <option value="">Select District</option> 
                                        @if(config('districts.districts'))
                                            @foreach ( config('districts.districts') as $district)
                                                <option value="{{$district}}">{{ $district }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('district'))
                                        <span class="help-block"><strong>{{ $errors->first('district') }}</strong></span>
                                    @endif
                                </div>
                                 <div class="mb-4 form-group{{ $errors->has('is_sms_enable') ? ' has-error' : '' }}">
                                    <label for="is_sms_enable" class="control-label">SMS Option <label class="text-danger">*</label></label>
                                    <select id="is_sms_enable" class="form-control select2" name="is_sms_enable" required>
                                        <option value="">SMS Option</option> 
                                        <option value="1">Enable</option> 
                                        <option value="0">Disable</option> 
                                    </select>
                                    @if ($errors->has('is_sms_enable'))
                                        <span class="help-block"><strong>{{ $errors->first('is_sms_enable') }}</strong></span>
                                    @endif
                                </div>
                                <div class="mb-4 form-group{{ $errors->has('school_address') ? ' has-error' : '' }}">
                                    <label for="school_address" class="control-label">Address <label class="text-danger">*</label></label>

                                    <textarea id="school_address" class="form-control" rows="3" name="school_address"
                                              placeholder="School Address" required>{{ old('school_address') }}</textarea>

                                    @if ($errors->has('school_about'))
                                        <span class="help-block"><strong>{{ $errors->first('school_address') }}</strong></span>
                                    @endif
                                </div>
                                <div class="mb-4 form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                                    <label for="logo" class="control-label">School Logo</label>

                                    <input id="logo" type="file" class="form-control" name="logo" required>

                                    @if ($errors->has('logo'))
                                        <span class="help-block"><strong>{{ $errors->first('logo') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-4 mt-5">
                                        <button type="submit" id="registerBtn" class="button button--save float-right"><i class="fas fa-plus mr-2"></i>Create School</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
