@extends('layouts.student-app')
@section('title', 'All Issued Book')
@section('content')
    <div class="container-fluid">
        <div class="breadcrumbs-area">
            <h3>
                Issued Books
            </h3>
            <ul>
                <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                        Back &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li>Issued Books</li>
            </ul>
        </div>
        <div class="card height-auto false-height">
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @component('components.issued-books-list',['books'=>$issued_books])
                @endcomponent
            </div>
        </div>
    </div>
@endsection
