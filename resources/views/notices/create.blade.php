@extends('layouts.student-app')

@section('title', 'Add Notice')

@section('content')
    <div class="breadcrumbs-area">
        <h3><a href="javascript:history.back()" class="float-left"><h4 style="color: #fea801; font-size: 22px;">Back</h4></a>&nbsp;&nbsp;Notices</h3>
        <ul style="margin-left: -100px !important;">
            <li>
                <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
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
