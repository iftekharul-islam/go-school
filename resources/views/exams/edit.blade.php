@extends('layouts.student-app')
@section('title', 'Add Examination')
@section('content')
    <div class="breadcrumbs-area">
        <h3><a href="javascript:history.back()" class="float-left"><h4 style="color: #fea801; font-size: 22px;">Back</h4></a>&nbsp;&nbsp;Add Exam</h3>
        <ul style="margin-left: -100px !important;">
            <li>
                <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
            </li>
            <li>Add Exams</li>
        </ul>
    </div>
    <div class="card height-auto">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @component('components.edit-exam-form',['classes'=>$classes,'assigned_classes'=>$already_assigned_classes, 'exam' => $exam])
            @endcomponent
        </div>
    </div>
{{--<div class="container-fluid">--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-2" id="side-navbar">--}}
{{--            @include('layouts.leftside-menubar')--}}
{{--        </div>--}}
{{--        <div class="col-md-8" id="main-container">--}}
{{--            <div class="panel panel-default">--}}
{{--                <div class="page-panel-title">Add Examination</div>--}}

{{--                <div class="panel-body">--}}
{{--                    @if (session('status'))--}}
{{--                        <div class="alert alert-success">--}}
{{--                            {{ session('status') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    @component('components.add-exam-form',['classes'=>$classes,'assigned_classes'=>$already_assigned_classes,])--}}
{{--                    @endcomponent--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
@endsection
