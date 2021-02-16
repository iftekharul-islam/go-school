@extends('layouts.student-app')

@section('title', 'Edit Department')

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>
                <i class='fas fa-microscope'></i>
                {{ __('text.edit') }}
            </h3>
            <ul>
                <li><a class="text-color mr-2" href="{{ URL::previous() }}">
                        {{ __('text.Back') }}</a>|
                    <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
                </li>
                <li>{{ __('text.edit') }}</li>
            </ul>
        </div>
        <div class="false-height">
            <div class="card height-auto">
                <div class="card-body">
                    <form method="POST" id="department" action="{{ route('department.update', $department->id) }}">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}
                        <div class="false-padding-bottom-form form-group{{ $errors->has('department_name') ? ' has-error' : '' }}">

                            <label for="departmentName"
                                   class="control-label false-padding-bottom">{{ __('text.Name') }}</label>

                            <input id="department_name" type="text"
                                   class="form-control" name="department_name"
                                   value="{{ $department->department_name ?? old('department_name') }}">

                            @if ($errors->has('department_name'))
                                <span class="help-block"><strong>{{ $errors->first('department_name') }}</strong></span>
                            @endif
                        </div>
                        <div class="form-group">
                            <button class="button button--save float-right" type="submit">{{ __('text.Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
