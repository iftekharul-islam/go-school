@extends('layouts.student-app')

@section('title', $book->title)

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class='fas fa-book'></i>
            Edit Book Details
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>
                <a style=" margin-left: 8px" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/all-books')  }}">
                    All Books
                </a>
            </li>
            <li>{{ $book->title }}</li>
        </ul>
    </div>


    <div class="card height-auto false-height">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @elseif(session('error'))
            @endif
                <form class="new-added-form justify-content-md-center aesteric" action="{{ route('update-book-details', $book->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                    @include('library.books.edit')
                    <div class="col-12 form-group mt-5">
                        <button type="submit" class="button button--save float-right">Save</button>
                    </div>
                </form>
        </div>
    </div>

@endsection

