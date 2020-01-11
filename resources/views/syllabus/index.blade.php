@extends('layouts.student-app')

@section('title', 'All Syllabus')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fab fa-readme"></i>
            All Syllabus
            <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.syllabuses')}}">See Inactive Syllabus</a>
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" style="color: #32998f!important;">Back &nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>All Syllabus</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <span class="d-inline-block float-right" tabindex="0" data-toggle="tooltip" title="Upload Syllabus">
                         <a href="{{ route('upload-syllabus') }}" class="float-right text-teal"><i class="fas fa-file-upload text-teal font-35"></i></a>
                    </span>

                </div>
            </div>
            @component('components.uploaded-files-list',['files'=>$files,'parent'=>($class_id !== 0)?'class':'','upload_type'=>'syllabus'])
            @endcomponent
        </div>
    </div>
@endsection
