{{$books->links()}}
<div class="table-responsive">
  <table class="table text-nowrap table-bordered table-data-div table-hover">
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">{{ __('text.book_title') }}</th>
      <th scope="col">{{ __('text.book_code') }}</th>
      <th scope="col">{{ __('text.type') }}</th>
      <th scope="col">{{ __('text.borrower_name') }}</th>
      <th scope="col">{{ __('text.borrower_code') }}</th>
      <th scope="col">{{ __('text.issued_date') }}</th>
      <th scope="col">{{ __('text.return_date') }}</th>
      <th scope="col">{{ __('text.action') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($books as $book)
      <tr>
        <td>{{ ($loop->index + 1) }}</td>
        <td>{{ $book->book->title }}</td>
        <td>{{ $book->book->book_code }}</td>
        <td>{{ $book->book->type }}</td>
        <td>{{ isset($book->student) ? $book->student->name : ''}}</td>
        <td>{{ isset($book->student) ? $book->student->student_code : ''}}</td>
        <td>{{ new_date_format($book->issue_date) }}</td>
        <td>{{ new_date_format($book->return_date) }}</td>
        <td>
          <form action="{{url( current_user()->role.'/save_as_returned')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="issue_id" value="{{$book->id}}">
            <input type="hidden" name="book_id" value="{{$book->book_id}}">
            <button class="button button--text float-left"><b>{{ __('text.save_as_returned')}}</b></button>
          </form>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>
{{$books->links()}}
