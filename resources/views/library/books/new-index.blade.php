@extends('layouts.student-app')

@section('title', 'All Books')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            All Books
        </h3>
        <ul>
            <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>All Books</li>
        </ul>
    </div>
    <div class="card height-auto false-height">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                </div>
            </div>

            <div class="table-responsive">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <table class="table display table-data-div text-wrap">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Details</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    @foreach($books as $book)
                        <tr>
                            <td>{{ ($loop->index + 1) }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->type }}</td>
                            <td>{{ $book->quantity }}</td>
                            <td>
                                <div class="">
                                    <a href="{{ route('library.books.show', $book->id) }}" class="button button--primary float-left">
                                        Detail
                                    </a>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-lg" type="button" onclick="book({{ $book->id }})">
                                    Delete
                                </button>
                                <form id="delete-form-{{ $book->id }}" action="{{ url('library/books', ['id' => $book->id]) }}" method="POST">
                                    {!! method_field('delete') !!}
                                    {!! csrf_field() !!}
{{--                                    <button type="submit" class="btn-lg btn btn-danger">Delete</button>--}}
                                </form>
                            </td>
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

@push('customjs')
    <script type="text/javascript">
        function book(id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.getElementById('delete-form-'+id).submit();
                    setTimeout(5000);
                    swal("Poof! Your Selected file has been deleted!", {
                        icon: "success",
                    });
                } else {
                    swal("Your Delete Operation has been canceled");
                }
            });
        }
    </script>
@endpush
