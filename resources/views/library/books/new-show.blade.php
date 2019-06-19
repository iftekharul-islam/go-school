@extends('layouts.student-app')

@section('title', 'All Books')

@section('content')
    <div class="breadcrumbs-area">
        <h3>Library</h3>
        <ul>
            <li>
                <a href="{{ url('/home') }}">Home</a>
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
            @endif
            <div class="table-responsive">
                <table class="table text-wrap">
                    <thead>
                    <tr>
                        <th>Book Code</th>
                        <td>{{ $book->book_code }}</td>
                        <th>Book Title</th>
                        <td>{{ $book->title }}</td>
                    </tr>
                    <tr>
                        <th>Author</th>
                        <td>{{ $book->author }}</td>
                        <th>row No</th>
                        <td>{{ $book->rowNo }}</td>
                    </tr>
                    <tr>
                        <th>About</th>
                        <td>{{ $book->about }}</td>
                        <th>Quantity</th>
                        <td>{{ $book->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Rack No</th>
                        <td>{{ $book->rackNo }}</td>
                        <th>Type</th>
                        <td>{{ $book->type }}</td>
                    </tr>
                    <tr>
                        <th>Class</th>
                        <td>{{ $book->class->class_number }}</td>
                        <th>School</th>
                        <td>{{ $book->school->name }}</td>
                    </tr>
                    <tr>
                        <th>Image</th>
                        <td>
                            <img src="{{ $book->img_path }}" alt="{{ $book->title }}" />
                        </td>
                        <th>Price</th>
                        <td>{{ $book->price }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $book->created_at }}</td>
                        <th>Updated At</th>
                        <td>{{ $book->updated_at }}</td>
                    </tr>
                    <tr>
                        <th>Registered By</th>
                        <td>{{ $book->user->name }}</td>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="row ml-2">
        <div class="com-md-6">
            <a href="{{ route('library.books.index') }}" class="fw-btn-fill btn-gradient-yellow">all books</a>
        </div>
    </div>
@endsection
