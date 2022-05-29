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
                    <div class="row">
                            <div class="col-12">
                                <form class="new-added-form grade-form" action="{{ url('admin/gpa/update', $grade_system->id) }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-12-xxxl col-lg-6 col-12 form-group{{ $errors->has('grade_system_name') ? ' has-error' : '' }}">
                                            <label>{{ __('text.grade_name') }}</label>
                                            <input id="grade_system_name" type="text" class="form-control" name="grade_system_name" value="{{ $grade_system->grade_system_name }}" required>

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
                </div>
            </div>
        </div>
    </div>
@endsection
