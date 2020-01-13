@extends('layouts.student-app')

@section('title', 'Add Event')

@section('content')

    <div class="breadcrumbs-area">
        <h3>
            <i class="fa fa-bullhorn"></i>
            All Events
            <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.events') }}">Inactive Events</a>
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>All Events</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @component('components.file-uploader',['upload_type'=>'event', 'section_id' => ''])
            @endcomponent
            <br>
            @component('components.uploaded-files-list',['files'=>$files,'upload_type'=>'event'])
            @endcomponent
        </div>
    </div>
@endsection
