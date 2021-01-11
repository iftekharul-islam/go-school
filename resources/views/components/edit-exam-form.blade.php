<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"
      rel="stylesheet">
<form class="new-added-form" action="{{url('admin/exams/edit',['id' => $exam->id])}}" method="post">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-8 form-group{{ $errors->has('term') ? ' has-error' : '' }}">
            <label>Term</label>
            <select id="term" class="select2" name="term">
                <option @if($exam->term == 'First Term') selected="selected" @endif value="First Term">1st Term</option>
                <option @if($exam->term == 'Second Term') selected="selected" @endif value="Second Term">2nd Term
                </option>
                <option @if($exam->term == 'Third Term') selected="selected" @endif value="Third Term">3rd Term</option>
                <option value="other">Other</option>
            </select>
            @if ($errors->has('term'))
                <span class="help-block">
                    <strong>{{ $errors->first('term') }}</strong>
                </span>
            @endif
        </div>
        <div id="other-term" class="col-md-8 form-group{{ $errors->has('other-term') ? ' has-error' : '' }}"
             style="display: none">
            <label>Term</label>
            <input id="other-term" type="text" class="form-control" name="other_term" value="{{ old('other-term') }}"
                   placeholder="Term title">
            @if ($errors->has('other-term'))
                <span class="help-block">
                    <strong>{{ $errors->first('other-term') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-8 form-group{{ $errors->has('exam_name') ? ' has-error' : '' }}">
            <label>Examination Name</label>
            <input id="exam_name" type="text" class="form-control" name="exam_name" value="{{ $exam->exam_name }}"
                   required>

            @if ($errors->has('exam_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('exam_name') }}</strong>
                </span>
            @endif
        </div>


        <div class="col-md-8 form-group{{ $errors->has('term') ? ' has-error' : '' }}">
            <label>Start Date</label>
            {{--            <input data-date-format="yyyy-mm-dd" id="start_date" class="form-control date" name="start_date"--}}
            {{--                   value="{{ $exam->start_date }}" placeholder="Start Date" autocomplete="off">--}}
            <input id="start_date" type="date" class="form-control" name="start_date"
                   value="{{ \Carbon\Carbon::parse($exam->start_date)->format('Y-m-d') }}" required>
            @if ($errors->has('start_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('start_date') }}</strong>
                </span>
            @endif
        </div>

        <div class="col-md-8 form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
            <label>End Date</label>
            <input id="end_date" type="date" class="form-control" name="end_date"
                   value="{{ \Carbon\Carbon::parse($exam->end_date)->format('Y-m-d') }}" required>
            {{--            <input data-date-format="yyyy-mm-dd" id="end_date" class="form-control date" name="end_date"--}}
            {{--                   value="{{ $exam->end_date }}" placeholder="End Date" autocomplete="off">--}}
            @if ($errors->has('end_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('end_date') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-md-8 form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
            <label>{{ __('text.for_class') }}</label>
            <select id="book_code" class="form-control select2 classes-exams" required multiple name="classes[]">
                @foreach($classes as $class)
                    @foreach($exam->class as $item)
                        @if($class->id == $item->class_id)
                            <option value="{{ $class->id }}" selected><b>Class - {{$class->class_number}}</b></option>
                        @endif
                    @endforeach
                    @if(in_array($class->id, $assigned_classes->pluck('class_id')->toArray()))
                        <!-- Need to check for assigned class -->
                        {{--                            <option value="" style="display: none" disabled><b>Class - {{$class->class_number}}</b>&nbsp;&nbsp; <small>(Exam Assigned)</small></option>--}}
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
        <div class="col-12 form-group mg-t-8">
            <button type="submit" class="button button--edit">Save</button>
            <a href="{{ URL::previous() }}" class="button button--cancel"
               style="margin-left: 1%;" role="button">Cancel</a>
        </div>
    </div>
</form>

<script>
    $(function () {
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
        });
    });
    $(document).ready(function () {
        $("#term").on("change", function () {
            if ($(this).val() === "other") {
                $("#other-term").show();
            } else {
                $("#other-term").hide();
            }
        });
    });
</script>
