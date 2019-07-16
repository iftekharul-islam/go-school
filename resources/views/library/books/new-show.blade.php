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
        <div class="row">
            <div class="col-12">
                <h3 class="float-left text-teal"><i class="fas fa-book mr-2 text-teal"></i> Book Details </h3>
            </div>

        </div>

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
                                                <td class="font-medium text-dark-medium">Book Code</td>
                                                <td>{{ $book->book_code }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium">Book Title</td>
                                                <td >{{ $book->title }}</td>
                                            </tr>
                                            <tr>
                                                <td  class="font-medium text-dark-medium">Author</td>
                                                <td>{{ $book->autdor }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium">Row No</td>
                                                <td>{{ $book->rowNo }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium">About</td>
                                                <td>{{ $book->about }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium">Quantity</td>
                                                <td>{{ $book->quantity }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium">Rack No</td>
                                                <td>{{ $book->rackNo }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium">Type</td>
                                                <td>{{ $book->type }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium">Class</td>
                                                <td>
                                                    {{ $book->class->class_number }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium">School</td>
                                                <td>{{ $book->school->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium">Created At</td>
                                                <td>{{ $book->created_at }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium">Updated At</td>
                                                <td>{{ $book->updated_at }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium">Registered By</td>
                                                <td>{{ $book->user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium">Price</td>
                                                <td>{{ $book->price }}</td>
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
