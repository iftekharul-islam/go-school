@extends('layouts.student-app')

@section('title', 'Add Notice')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
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
                @component('components.file-uploader',['upload_type'=>'notice', 'section_id' => ''])
                @endcomponent
                <br>
                @component('components.uploaded-files-list',['files'=>$files,'upload_type'=>'notice'])
                @endcomponent
        </div>
    </div>
@endsection
