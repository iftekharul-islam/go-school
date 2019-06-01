@extends('layouts.app')

@section('title', 'Add Routine')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>Routine</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @component('components.file-uploader',['upload_type'=>'routine', 'section_id' => $section_id])
            @endcomponent
            @component('components.uploaded-files-list',['files'=>$files,'parent'=>($section_id !== 0)?'section':'','upload_type'=>'routine'])
            @endcomponent
        </div>
    </div>
@endsection
