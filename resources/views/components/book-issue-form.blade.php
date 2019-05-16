<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"
      rel="stylesheet">
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.min.css">

<!-- JS -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.min.js"></script>


<form class="new-added-form justify-content-md-center false-height" action="{{url('library/issue-books')}}" method="post">
    {{ csrf_field() }}
    <div class="form-group{{ $errors->has('student_code') ? ' has-error' : '' }}">
        <label for="name" class="col-md-4">Student Code</label>

        <div class="col-md-6">
            <input id="student_code" type="text" class="form-control" name="student_code" value="{{ old('student_code') }}" placeholder="Student Code" required>

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('student_code') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('book_code') ? ' has-error' : '' }}">
        <label class="col-md-4">Book Title &amp; Code (Maximum 10 books)</label>

        <div class="col-md-6">
            <select id="book_code" class="col-12 form-group" multiple name="book_id[]">
                @foreach($books as $book)
                    <option value="{{$book->id}}">{{$book->title}} - {{$book->book_code}}</option>
                @endforeach
            </select>
        </div>
{{--        <div class="col-xl-6 col-lg-6 col-12 form-group">--}}
{{--            <select class="select2" id="book_code" multiple name="book_id[]">--}}
{{--                @foreach($books as $book)--}}
{{--                    <option value="{{$book->id}}">{{$book->title}} - {{$book->book_code}}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
    </div>

    <div class="form-group{{ $errors->has('issue_date') ? ' has-error' : '' }}">
        <label class="col-md-4 control-label">Issue Date</label>

        <div class="col-md-6">
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

        <div class="col-md-6">
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
        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
    </div>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function () {
        $('#book_code').chosen({
            max_selected_options: 10,
            display_selected_options: true,
        });
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
        });
    })
</script>