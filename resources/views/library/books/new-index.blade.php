@extends('layouts.student-app')

@section('title', 'All Books')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class='fas fa-book'></i>
            {{ __('text.All Books') }}
        </h3>
        <ul>
            <li> <a class="text-color mr-2" href="{{ URL::previous() }}">
                    {{ __('text.Back') }}</a>|
                <a class="text-color" href="{{ url(current_user()->role.'/home') }}">{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.All Books') }}</li>
        </ul>
    </div>
    <?php $role = current_user()->role ?>
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
                        <th>{{ __('text.title') }}</th>
                        <th>{{ __('text.author') }}</th>
                        <th>{{ __('text.type') }}</th>
                        <th>{{ __('text.quantity') }}</th>
                        <th>{{ __('text.Details') }}</th>
                        <th>{{ __('text.action') }}</th>
                    </tr>
                    </thead>
                    @foreach($books as $book)
                        <tr>
                            <td>{{ ($loop->index + 1) }}</td>
                            <td><a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/book', $book->id) }}" class="text-teal">
                                    {{ $book->title }}
                                </a></td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->type }}</td>
                            <td>{{ $book->quantity }}</td>
                            <td>
                                <div class="">
                                    <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/book', $book->id) }}" class="button button--save float-left">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <button class="button button--cancel" type="button" onclick="book({{ $book->id }})">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                <form id="delete-form-{{ $book->id }}" action="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/books', $book->id) }}" method="POST">
                                    {!! method_field('delete') !!}
                                    {!! csrf_field() !!}
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
                title: "{{ __('text.conform_msg') }}",
                text: "{{ __('text.conform_info') }}",
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
                    }
                });
        }
    </script>
@endpush
