<form class="new-added-form" action="{{url('admin/exams/create')}}" method="post">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12 form-group{{ $errors->has('term') ? ' has-error' : '' }}">
            <label>{{ __('text.term') }}</label>
            <select id="term" class="select2 ml-2 " name="term">
               <option value="First Term">1st Term</option>
               <option value="Second Term">2nd Term</option>
               <option value="Third Term">3rd Term</option>
               <option value="other">Other</option>
            </select>
            @if ($errors->has('term'))
                <span class="help-block">
                    <strong>{{ $errors->first('term') }}</strong>
                </span>
            @endif
        </div>
        <div id="other-term" class="col-md-12 form-group{{ $errors->has('other-term') ? ' has-error' : '' }}" style="display: none">
            <label>Term</label>
            <input id="other-term" type="text" class="form-control" name="other_term" value="{{ old('other-term') }}" placeholder="Term title">
            @if ($errors->has('other-term'))
                <span class="help-block">
                    <strong>{{ $errors->first('other-term') }}</strong>
                </span>
            @endif
        </div>

        <div class="col-md-12 form-group{{ $errors->has('exam_name') ? ' has-error' : '' }}">
            <label>{{ __('text.exam_name') }}</label>
            <input id="exam_name" type="text" class="form-control" name="exam_name" value="{{ old('exam_name') }}" placeholder="Semester 1 Exam 2018, Final Exam 2019, ..." required>

            @if ($errors->has('exam_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('exam_name') }}</strong>
                </span>
            @endif
        </div>


        <div class="col-md-12 form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
            <label>{{ __('text.Start Date') }}</label>
            <input data-date-format="yyyy-mm-dd" id="start_date" class="form-control date" name="start_date" value="{{ old('start_date') }}" placeholder="Start Date" required autocomplete="off">
            @if ($errors->has('start_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('start_date') }}</strong>
                </span>
            @endif
        </div>

        <div class="col-md-12 form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
            <label>{{ __('text.End Date') }}</label>
            <input data-date-format="yyyy-mm-dd" id="end_date" class="form-control date" name="end_date" value="{{ old('end_date') }}" placeholder="End Date" required autocomplete="off">
            @if ($errors->has('end_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('end_date') }}</strong>
                </span>
            @endif
        </div>

        <div class="col-md-12 form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
            <label>{{ __('text.for_class') }}</label>
                <select id="book_code" required class="form-control select2 classes-exams" multiple name="classes[]">
                    @foreach($classes as $class)
                            @if(in_array($class->id, $assigned_classes->pluck('class_id')->toArray()))
                                <option value="" disabled><b>Class - {{$class->class_number}}</b>&nbsp;&nbsp; <small>(Exam Assigned)</small></option>
                            @else
                                <option value="{{ $class->id}}"><b>Class - {{$class->class_number}}</b></option>
                            @endif
                    @endforeach
                </select>

            @if ($errors->has('classes'))
                <span class="help-block">
                    <strong>{{ $errors->first('classes') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-12 form-group mg-t-8" style="text-align: right">
            <a href="{{ URL::previous() }}" class="button button--cancel mr-2" style="margin-left: 1%;" role="button"><b>{{ __('text.Cancel') }}</b></a>
            <button type="submit" class="button button--save"><b>{{ __('text.Save') }}</b></button>
        </div>
    </div>
</form>

<script>
    $(function () {
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            language: 'en'
        });
    });
    $(document).ready(function() {
        $("#term").on("change", function() {
            if ($(this).val() === "other") {
                $("#other-term").show();
            } else {
                $("#other-term").hide();
            }
        });
    });

</script>
