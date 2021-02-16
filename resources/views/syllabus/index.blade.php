@extends('layouts.student-app')

@section('title', 'All Syllabus')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fab fa-readme"></i>
            {{ __('text.all_syllabus') }}
            <a class="btn btn-lg btn-info float-right font-bold" href="{{ route('inactive.syllabuses')}}">Inactive Syllabus</a>
        </h3>
        <ul>
            <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }}</a>|
                <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.all_syllabus') }}</li>
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
