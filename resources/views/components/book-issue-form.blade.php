{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet">--}}
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.min.css">
<!-- JS -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.jquery.min.js"></script>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form autocomplete="off" class="new-added-form justify-content-md-center book-issue" action="{{url(current_user()->role.'/issue-books')}}" method="post">
    {{ csrf_field() }}
    <div class="form-group">
        <div class="col-md-12">
            <label for="class_number" class="mt-5">{{ __('text.Class') }}</label>
            <select name="class" id="class_number" class="select2 form-control" onchange="getSections(this.value)">
                <option>Select Class</option>
                @foreach($classes as $class)
                    <option
                        value="{{ $class->id }}" {{ $class->class_number ==  $class_number ? 'selected' : '' }}>
                        class - {{ $class->class_number }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <label>{{ __('text.Section') }}</label>
            <select class="form-control select2" id="section" name="section" onchange="getStudents(this.value);"></select>
        </div>
    </div>
    <div class="form-group{{ $errors->has('student_id') ? ' has-error' : '' }}">
        <div class="col-md-12">
            <label for="student">{{ __('text.Name') }}</label>
            <select class="form-control select2" id="student" name="student_id" required></select>
            @if ($errors->has('student_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('student_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('book_code') ? ' has-error' : '' }}">
        <div class="col-md-12">
            <label>{{ __('text.book_title_code') }} (Maximum 10 books)</label>

            <select id="book_code" class="form-control select2" multiple name="book_id[]">
                @foreach($books as $book)
                    <option value="{{$book->id}}">{{$book->title}} - {{$book->book_code}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group{{ $errors->has('issue_date') ? ' has-error' : '' }}">

        <div class="col-md-12">
            <label class="control-label">{{ __('text.issued_date') }}</label>

            <input data-date-format="yyyy-mm-dd" id="issue_date" class="form-control date" name="issue_date" value="{{ old('issue_date') }}" placeholder="Issue Date" required>

            @if ($errors->has('issue_date'))
                <span class="help-block">
                <strong>{{ $errors->first('issue_date') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('return_date') ? ' has-error' : '' }}">

        <div class="col-md-12">
            <label class="control-label">{{ __('text.return_date') }}</label>

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
        <button type="submit" class="button button--save float-right"><b>{{ __('text.save') }}</b></button>
    </div>
</form>

<script>

    let classes = {!! json_encode($classes->toArray()) !!};
    let sections = [];

    function getSections(item) {
        let selectedClass = item;
        classes.forEach((cls) => {
            if (cls.id == selectedClass) {
                sections = cls.sections;
                return false;
            }
        });

        $('#section').empty();
        $('#section').append($("<option />").val('').text('Select a section'));
        sections.forEach((sec) => {
            $('#section').append($("<option />").val(sec.id).text(sec.section_number));
        });
    };

    function getStudents(item) {
        let selectedStudent = item;
        let students = [];
        sections.forEach((section) => {
            if (section.id == selectedStudent) {
                students = section.students;
                return false;
            }
        });

        $('#student').empty();
        $('#student').append($("<option />").val('').text('Select a student'));
        students.forEach((std) => {
            $('#student').append($("<option />").val(std.id).text(std.name));
        });
    };

</script>
