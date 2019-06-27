@extends('layouts.student-app')

@section('title', 'All Books')

@section('content')
<div class="breadcrumbs-area">
    <h3>
        Book Details
    </h3>
    <ul>
        <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                Back &nbsp;&nbsp;|</a>
            <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
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
        <h3 class="text-center"> Book Details </h3>

        <div class="row">
            <div class="col-md-3 library-image"><img src="{{ $book->img_path }}" alt="{{ $book->title }}" /></div>
            <div class="col-md-9">
                <div class="account-settings-box">
                    <div class="">
                        <div class="user-details-box">
                            <div class="item-content">
                                <div class="info-table table-responsive">
                                    <table class="table text-wrap">
                                        <tbody>
                                            <tr>
                                                <td>Book Code</td>
                                                <td class="font-medium text-dark-medium">{{ $book->book_code }}</td>
                                            </tr>
                                            <tr>
                                                <td>Book Title</td>
                                                <td class="font-medium text-dark-medium">{{ $book->title }}</td>
                                            </tr>
                                            <tr>
                                                <td>Autdor</td>
                                                <td class="font-medium text-dark-medium">{{ $book->autdor }}</td>
                                            </tr>
                                            <tr>
                                                <td>row No</td>
                                                <td class="font-medium text-dark-medium">{{ $book->rowNo }}</td>
                                            </tr>
                                            <tr>
                                                <td>About</td>
                                                <td class="font-medium text-dark-medium">{{ $book->about }}</td>
                                            </tr>
                                            <tr>
                                                <td>Quantity</td>
                                                <td class="font-medium text-dark-medium">{{ $book->quantity }}</td>
                                            </tr>
                                            <tr>
                                                <td>Rack No</td>
                                                <td class="font-medium text-dark-medium">{{ $book->rackNo }}</td>
                                            </tr>
                                            <tr>
                                                <td>Type</td>
                                                <td class="font-medium text-dark-medium">{{ $book->type }}</td>
                                            </tr>
                                            <tr>
                                                <td>Class</td>
                                                <td class="font-medium text-dark-medium">
                                                    {{ $book->class->class_number }}</td>
                                            </tr>
                                            <tr>
                                                <td>School</td>
                                                <td class="font-medium text-dark-medium">{{ $book->school->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Created At</td>
                                                <td class="font-medium text-dark-medium">{{ $book->created_at }}</td>
                                            </tr>
                                            <tr>
                                                <td>Updated At</td>
                                                <td class="font-medium text-dark-medium">{{ $book->updated_at }}</td>
                                            </tr>
                                            <tr>
                                                <td>Registered By</td>
                                                <td class="font-medium text-dark-medium">{{ $book->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Price</td>
                                                <td class="font-medium text-dark-medium">{{ $book->price }}</td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
