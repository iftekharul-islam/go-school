@extends('layouts.student-app')
@section('title', 'All Active Examinations')
@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>All Examinations</li>
        </ul>
    </div>

    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 10px;">Back</h4></a>
                    <h3>All Active Exams</h3>
                </div>
            </div>
            @if(count($exams) > 0)
                @foreach($exams as $exam)
                    @component('components.active-exams',['exam'=>$exam,'courses'=>$courses])
                    @endcomponent
                @endforeach
            @endif
        </div>
    </div>
@endsection
