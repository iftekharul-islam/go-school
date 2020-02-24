@extends('layouts.student-app')

@section('title', 'Notices')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-exclamation-circle"></i>
            Notices
            <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.notices')}}">Inactive Notices</a>
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Notices</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
                <a href="{{ route('create.notice') }}" class="button button--save mr-2">Create Notice</a>
            @component('components.uploaded-notices-list',['files'=>$files,'upload_type'=>'notice'])
                @endcomponent
        </div>
    </div>
@endsection
