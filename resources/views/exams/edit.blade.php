@extends('layouts.student-app')
@section('title', 'Add Examination')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            </a>Add Exams
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
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
@endsection
