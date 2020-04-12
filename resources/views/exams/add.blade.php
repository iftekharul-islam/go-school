@extends('layouts.student-app')
@section('title', 'Add Examination')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-file-alt"></i>
            {{ __('text.Add Examination') }}
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li> {{ __('text.Add Examination') }}</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card height-auto false-height">
                <div class="card-body">
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

                    @component('components.add-exam-form',['classes'=>$classes,'assigned_classes'=>$already_assigned_classes,])
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
@endsection
