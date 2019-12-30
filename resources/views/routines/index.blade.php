@extends('layouts.student-app')

@section('title', 'All Routines')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fa fa-calendar"></i>
            All Routines
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" style="color: #32998f!important;">Back &nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>All Routine</li>
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
                    <span class="d-inline-block float-right" tabindex="0" data-toggle="tooltip" title="Upload Routine">
                         <a href="{{ route('upload-routine') }}" class="float-right text-teal"><i class="fas fa-file-upload text-teal font-35"></i></a>
                    </span>

                    </div>
                </div>
            @component('components.uploaded-files-list',['files'=>$files,'parent'=>($section_id !== 0)?'section':'','upload_type'=>'routine'])
            @endcomponent
        </div>
    </div>
@endsection
