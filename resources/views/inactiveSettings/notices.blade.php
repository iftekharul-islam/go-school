@extends('layouts.student-app')

@section('title', 'Inactive Notices')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-exclamation-circle"></i>
            Inactive Notices
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Inactive Notices</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <br>
            @component('components.uploaded-files-list',['files'=>$files,'upload_type'=>'notice'])
            @endcomponent
        </div>
    </div>
@endsection
