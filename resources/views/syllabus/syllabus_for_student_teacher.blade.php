@extends('layouts.student-app')

@section('title', 'All Syllabus')

@section('content')
    <div class="breadcrumbs-area">
        <h3><i class="fas fa-list"></i> {{ __('text.Syllabus') }} </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}">Back &nbsp;|</a>
                <a href="{{ url( current_user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Syllabus</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @component('components.syllabus', [ 'syllabuses' => $syllabuses ])
            @endcomponent
        </div>
    </div>
@endsection
