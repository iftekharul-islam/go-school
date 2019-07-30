<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet">
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.min.css">
<!-- JS -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form autocomplete="off" class="new-added-form justify-content-md-center book-issue" action="{{url(\Illuminate\Support\Facades\Auth::user()->role.'/issue-books')}}" method="post">
    {{ csrf_field() }}
    <div class="form-group{{ $errors->has('student_code') ? ' has-error' : '' }}">
        <label for="name" class="col-md-4 mt-5">Student Name</label>

        <div class="col-md-12">
            <input id="show-user" type="text" class="typeahead form-control" name="name" value="{{ old('student_code') }}" placeholder="Student Name" required>

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('book_code') ? ' has-error' : '' }}">
        <label class="col-md-4">Book Title &amp; Code (Maximum 10 books)</label>

        <div class="col-md-12">
            <select id="book_code" class="form-control select2" multiple name="book_id[]">
                @foreach($books as $book)
                    <option value="{{$book->id}}">{{$book->title}} - {{$book->book_code}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group{{ $errors->has('issue_date') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Issue Date</label>

        <div class="col-md-12">
            <input data-date-format="yyyy-mm-dd" id="issue_date" class="form-control date" name="issue_date" value="{{ old('issue_date') }}" placeholder="Issue Date" required>

            @if ($errors->has('issue_date'))
                <span class="help-block">
                <strong>{{ $errors->first('issue_date') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('return_date') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Return Date</label>

        <div class="col-md-12">
            <input data-date-format="yyyy-mm-dd" id="return_date" class="form-control date" name="return_date" value="{{ old('return_date') }}"
                   placeholder="Return Date" required>
            @if ($errors->has('return_date'))
                <span class="help-block">
                <strong>{{ $errors->first('return_date') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="col-12 form-group mg-t-8">
        <button type="submit" class="button button--save float-right"><b>Save</b></button>
    </div>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function () {
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
        });
        var path = "{{ url('/librarian/issue-books/autocomplete/{$query}') }}";
        $('input.typeahead').typeahead({
            source:  function (query, process) {
                return $.get(path + $('#show-user').val(), {}, function (data) {
                    return process(data);
                });
            }
        });
    })
</script>