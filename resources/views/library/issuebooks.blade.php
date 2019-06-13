@extends('layouts.student-app')
@section('title', 'Issue Book')
@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
            </li>
            <li>Issue books</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 8px;">Back</h4></a>
                    <h3>Issue book</h3>
                </div>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @component('components.book-issue-form',['books'=>$books])
            @endcomponent
        </div>
    </div>
@endsection
