@extends('layouts.student-app')

@section('title', 'Add Syllabus')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Add Syllabus
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Add Syllabus</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @component('components.file-uploader',['upload_type'=>'syllabus', 'section_id' => $class_id])
            @endcomponent
                <br>
            @component('components.uploaded-files-list',['files'=>$files,'parent'=>($class_id !== 0)?'class':'','upload_type'=>'syllabus'])
            @endcomponent
        </div>
    </div>
@endsection
