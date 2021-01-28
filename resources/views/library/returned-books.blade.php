@extends('layouts.student-app')

@section('title', 'Returned Books history')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class='fas fa-book'></i>
            {{ __('text.returned_books_history') }}
        </h3>
        <ul>
            <li>
                <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url( current_user().'/home' ) }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.returned_books_history') }}</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="table-responsive">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <table class="table display table-bordered table-data-div text-wrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('text.Name') }}</th>
                        <th>{{ __('text.author') }}</th>
                        <th>{{ __('text.type') }}</th>
                        <th>{{ __('text.borrower_name') }}</th>
                        <th>{{ __('text.Class') }}</th>
                        <th>{{ __('text.Section') }}</th>
                        <th>{{ __('text.issued_date') }}</th>
                        <th>{{ __('text.return_date') }}</th>
                        <th>{{ __('text.fine') }}</th>
                    </tr>
                    </thead>
                    @foreach($books as $book)
                        <tr>
                            <td>{{ ($loop->index + 1) }}</td>
                            <td><a href="{{ url( current_user().'/book', $book->id ) }}"
                                   class="text-teal">
                                    {{ $book->book->title }}
                                </a></td>
                            <td>{{ $book->book->author }}</td>
                            <td>{{ $book->book->type }}</td>
                            <td>{{ $book->student->name }}</td>
                            <td>{{ $book->student->section->class->class_number }}</td>
                            <td>{{ $book->student->section->section_number }}</td>
                            <td>{{ new_date_format($book->issue_date) }}</td>
                            <td>{{ new_date_format($book->return_date) }}</td>
                            <td>{{ $book->fine }}</td>
                        </tr>
                    @endforeach
                </table>
                <div class="paginate123 mt-5 float-right">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
