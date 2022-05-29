@extends('layouts.student-app')
@section('title', 'Add GPA System')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-poll-h"></i>
            {{ __('text.create_grade') }}
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.create_grade') }}</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card height-auto ">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(!$grade_systems)
                        <div class="row">
                            <div class="col-12">
                                <form class="new-added-form grade-form" action="{{ url('admin/store-grade-system') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-12-xxxl col-lg-6 col-12 form-group{{ $errors->has('grade_system_name') ? ' has-error' : '' }}">
                                            <label>{{ __('text.grade_name') }}</label>
                                            <input id="grade_system_name" type="text" class="form-control" name="grade_system_name" value="{{ old('grade_system_name') }}" placeholder="Grade System Name" required>

                                            @if ($errors->has('grade_system_name'))
                                                <span class="help-block">
                                      <strong>{{ $errors->first('grade_system_name') }}</strong>
                                  </span>
                                            @endif
                                        </div>
                                        <div class="col-12 form-group">
                                            <button type="submit" class="button button--save float-right ml-3"><b>Save</b></button>
                                            <a href="{{ URL::previous() }}" class="button button--cancel float-right" style="margin-left: 1%" role="button"><b>{{ __('text.Cancel') }}</b></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-12">
                                <form class="new-added-form" action="{{url('admin/store-gpa-info')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <input type="hidden" value="{{ $grade_systems->id }}" name="grade_system_id">
                                        <div class="col-12-xxxl col-lg-6 col-12 form-group{{ $errors->has('grade') ? ' has-error' : '' }}">
                                            <label>{{ __('text.Grades') }}</label>
                                            <input id="grade" type="text" class="form-control" name="grade" value="{{ old('grade') }}" placeholder="A+, A, A-, B+, ..." required>

                                            @if ($errors->has('grade'))
                                                <span class="help-block">
                                      <strong>{{ $errors->first('grade') }}</strong>
                                  </span>
                                            @endif
                                        </div>
                                        <div class="col-12-xxxl col-lg-6 col-12 form-group{{ $errors->has('point') ? ' has-error' : '' }}">
                                            <label>{{ __('text.grade_point') }}</label>
                                            <input id="point" type="text" class="form-control" name="point" value="{{ old('point') }}" placeholder="5.00, 4.50, ..." required>

                                            @if ($errors->has('point'))
                                                <span class="help-block">
                                      <strong>{{ $errors->first('point') }}</strong>
                                  </span>
                                            @endif
                                        </div>
                                        <div class="col-12-xxxl col-lg-6 col-12 form-group{{ $errors->has('from_mark') ? ' has-error' : '' }}">
                                            <label>{{ __('text.from_mark') }}</label>
                                            <input id="from_mark" type="text" class="form-control" name="from_mark" value="{{ old('from_mark') }}" placeholder="Example: 80">

                                            @if ($errors->has('from_mark'))
                                                <span class="help-block">
                                      <strong>{{ $errors->first('from_mark') }}</strong>
                                  </span>
                                            @endif
                                        </div>
                                        <div class="col-12-xxxl col-lg-6 col-12 form-group{{ $errors->has('to_mark') ? ' has-error' : '' }}">
                                            <label>{{ __('text.to_mark') }}</label>
                                            <input id="to_mark" type="text" class="form-control" name="to_mark" value="{{ old('to_mark') }}" placeholder="Example: 90">

                                            @if ($errors->has('to_mark'))
                                                <span class="help-block">
                                      <strong>{{ $errors->first('to_mark') }}</strong>
                                  </span>
                                            @endif
                                        </div>

                                        <div class="col-12 form-group mg-t-8">
                                            <button type="submit" class="button button--save float-right"><b>{{ __('text.save') }}</b></button>
                                            <a href="{{ URL::previous() }}" class="button button--cancel float-right mr-3"  role="button"><b>{{ __('text.Cancel') }}</b></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
