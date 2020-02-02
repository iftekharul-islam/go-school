@extends('layouts.student-app')

@section('title', 'Students List')

@section('content')
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <style>
        .ck-editor__editable{
            min-height: 200px;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" id="main-container">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @component('components.new-users-list',['users'=>$users, 'classes' => $classes, 'searchData' => $searchData, 'type' => $type])
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
