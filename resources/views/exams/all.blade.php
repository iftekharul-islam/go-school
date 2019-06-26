@extends('layouts.student-app')
@section('title', 'All Examinations')
@section('content')
    <div class="breadcrumbs-area">
        <h3><a href="javascript:history.back()" class="float-left"><h4 style="color: #fea801; font-size: 28px;">Back</h4></a>&nbsp;&nbsp;All Exams</h3>
        <ul class="float-left" style="margin-left: -60px !important;">
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>All Exams</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @component('components.exams-list',['exams'=>$exams])
            @endcomponent
        </div>
    </div>
@endsection
