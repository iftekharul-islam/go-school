@extends('layouts.student-app')

@section('title', 'Create Department')

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>
                <i class="fas fa-cog fa-fw"></i>
               {{ __('text.Add Department') }}
            </h3>
            <ul>
                <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                        {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
                </li>
                <li> {{ __('text.Add Department') }}</li>
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
            <div class="card height-auto">
                <div class="card-body">
                    <form class="new-added-form" action="{{ route('school.add.department') }}" method="post">
                        {{csrf_field()}}
                        <div class="false-padding-bottom-form form-group">
                            <label for="department_name"
                                   class="col-sm-12 control-label false-padding-bottom">{{ __('text.department_name') }}<label class="text-danger">*</label></label>
                            <div class="col-sm-12">
                                <input type="text" required class="form-control"
                                       id="department_name"
                                       name="department_name"
                                       placeholder="English, Math,...">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-12">
                                <button type="submit"
                                        class="button button--save float-right">
                                    {{ __('text.Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
