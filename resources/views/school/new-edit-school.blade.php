@extends('layouts.student-app')

@section('title', 'Create School')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Edit School
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Edit School</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card height-auto false-height">
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
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" method="POST" action="{{ url('master/school/edit', $school->id) }}">
                                {{ csrf_field() }}
{{--                                {{ method_field('POST' }}--}}
                                <div class="mb-4 form-group{{ $errors->has('school_name') ? ' has-error' : '' }}">
                                    <label for="school_name" class="control-label">School Name</label>

                                    <input id="school_name" type="text" class="form-control" name="school_name"
                                           value="{{ $school->name }}" placeholder="School Name" required>

                                    @if ($errors->has('school_name'))
                                        <span class="help-block">
                          <strong>{{ $errors->first('school_name') }}</strong>
                      </span>
                                    @endif
                                </div>
                                <div class="mb-4 form-group{{ $errors->has('school_medium') ? ' has-error' : '' }}">
                                    <label for="school_medium" class="control-label">School Medium</label>

                                    <select id="school_medium" class="select2" name="school_medium">
                                        <option selected="selected">Bangla</option>
                                        <option>English</option>
                                    </select>

                                    @if ($errors->has('school_medium'))
                                        <span class="help-block">
                          <strong>{{ $errors->first('school_medium') }}</strong>
                      </span>
                                    @endif
                                </div>
                                <div class="mb-4 form-group{{ $errors->has('school_about') ? ' has-error' : '' }}">
                                    <label for="school_about" class="control-label">About</label>

                                    <textarea id="school_about" class="form-control" rows="3" name="school_about"
                                              placeholder="About School" required>{{ old('school_about') }}>{{ $school->about }}</textarea>

                                    @if ($errors->has('school_about'))
                                        <span class="help-block">
                          <strong>{{ $errors->first('school_about') }}</strong>
                      </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-4 mt-5">
                                <button type="submit" id="registerBtn"
                                        class="button button--save font-weight-bold float-left">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection