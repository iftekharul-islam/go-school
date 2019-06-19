@extends('layouts.student-app')

@section('title', 'Create School')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>Create School</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 10px;">Back</h4></a>
                    <h3>Create School</h3>
                </div>
            </div>
            <form class="form-horizontal" method="POST" action="{{ url('create-school') }}">
                {{ csrf_field() }}
                <div class="row mt-5">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('school_name') ? ' has-error' : '' }}">
                            <label for="school_name" class="col-md-4 control-label">School Name</label>

                            <div class="col-md-12">
                                <input id="school_name" type="text" class="form-control" name="school_name" value="{{ old('school_name') }}" placeholder="School Name" required>

                                @if ($errors->has('school_name'))
                                    <span class="help-block">
                          <strong>{{ $errors->first('school_name') }}</strong>
                      </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('school_medium') ? ' has-error' : '' }}">
                            <label for="school_medium" class="col-md-4 control-label">School Medium</label>

                            <div class="col-md-12">
                                <select id="school_medium" class="form-control" name="school_medium">
                                    <option selected="selected">Bangla</option>
                                    <option>English</option>
                                </select>

                                @if ($errors->has('school_medium'))
                                    <span class="help-block">
                          <strong>{{ $errors->first('school_medium') }}</strong>
                      </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('school_established') ? ' has-error' : '' }}">
                            <label for="school_established" class="col-md-6 control-label">School Established</label>

                            <div class="col-md-12">
                                <input id="school_established" type="text" class="form-control" name="school_established" value="{{ old('school_established') }}" placeholder="School Established" required>

                                @if ($errors->has('school_established'))
                                    <span class="help-block">
                          <strong>{{ $errors->first('school_established') }}</strong>
                      </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('school_about') ? ' has-error' : '' }}">
                            <label for="school_about" class="col-md-4 control-label">About</label>

                            <div class="col-md-12">
                                <textarea id="school_about" class="form-control" rows="3" name="school_about" placeholder="About School" required>{{ old('school_about') }}</textarea>

                                @if ($errors->has('school_about'))
                                    <span class="help-block">
                          <strong>{{ $errors->first('school_about') }}</strong>
                      </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 ml-4 col-md-offset-4 mt-5">
                            <button type="submit" id="registerBtn" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">
                                Save
                            </button>
                        </div>
                    </div>
                </div>


{{--                <div class="modal-content">--}}
{{--                    <div class="modal-header" style="display: inline-block;">--}}
{{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
{{--                        <h4 class="modal-title" id="myModalLabel">Create School</h4>--}}
{{--                    </div>--}}
{{--                    <div class="modal-body">--}}
{{--                        <div class="form-group{{ $errors->has('school_name') ? ' has-error' : '' }}">--}}
{{--                            <label for="school_name" class="col-md-4 control-label">School Name</label>--}}

{{--                            <div class="col-md-12">--}}
{{--                                <input id="school_name" type="text" class="form-control" name="school_name" value="{{ old('school_name') }}" placeholder="School Name" required>--}}

{{--                                @if ($errors->has('school_name'))--}}
{{--                                    <span class="help-block">--}}
{{--                          <strong>{{ $errors->first('school_name') }}</strong>--}}
{{--                      </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group{{ $errors->has('school_medium') ? ' has-error' : '' }}">--}}
{{--                            <label for="school_medium" class="col-md-4 control-label">School Medium</label>--}}

{{--                            <div class="col-md-12">--}}
{{--                                <select id="school_medium" class="form-control" name="school_medium">--}}
{{--                                    <option selected="selected">Bangla</option>--}}
{{--                                    <option>English</option>--}}
{{--                                </select>--}}

{{--                                @if ($errors->has('school_medium'))--}}
{{--                                    <span class="help-block">--}}
{{--                          <strong>{{ $errors->first('school_medium') }}</strong>--}}
{{--                      </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group{{ $errors->has('school_established') ? ' has-error' : '' }}">--}}
{{--                            <label for="school_established" class="col-md-6 control-label">School Established</label>--}}

{{--                            <div class="col-md-12">--}}
{{--                                <input id="school_established" type="text" class="form-control" name="school_established" value="{{ old('school_established') }}" placeholder="School Established" required>--}}

{{--                                @if ($errors->has('school_established'))--}}
{{--                                    <span class="help-block">--}}
{{--                          <strong>{{ $errors->first('school_established') }}</strong>--}}
{{--                      </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="form-group{{ $errors->has('school_about') ? ' has-error' : '' }}">--}}
{{--                            <label for="school_about" class="col-md-4 control-label">About</label>--}}

{{--                            <div class="col-md-12">--}}
{{--                                <textarea id="school_about" class="form-control" rows="3" name="school_about" placeholder="About School" required>{{ old('school_about') }}</textarea>--}}

{{--                                @if ($errors->has('school_about'))--}}
{{--                                    <span class="help-block">--}}
{{--                          <strong>{{ $errors->first('school_about') }}</strong>--}}
{{--                      </span>--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="modal-footer">--}}
{{--                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>--}}
{{--                        <button type="submit" class="btn btn-primary">Save changes</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </form>
        </div>
    </div>

    @endsection