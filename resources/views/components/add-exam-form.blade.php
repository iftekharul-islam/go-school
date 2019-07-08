<form class="new-added-form" action="{{url('exams/create')}}" method="post">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12 form-group{{ $errors->has('term') ? ' has-error' : '' }}">
            <label>Terms</label>
            <select id="term" class="select2 ml-2 " name="term">
               <option value="1">1st Term</option>
               <option value="2">2nd Term</option>
               <option value="3">3rd Term</option>
            </select>
            @if ($errors->has('term'))
                <span class="help-block">
                    <strong>{{ $errors->first('term') }}</strong>
                </span>
            @endif
        </div>


        <div class="col-md-12 form-group{{ $errors->has('exam_name') ? ' has-error' : '' }}">
            <label>Examination Name</label>
            <input id="exam_name" type="text" class="form-control" name="exam_name" value="{{ old('exam_name') }}" placeholder="Semester 1 Exam 2018, Final Exam 2019, ..." required>

            @if ($errors->has('exam_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('exam_name') }}</strong>
                </span>
            @endif
        </div>


        <div class="col-md-12 form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
            <label>Start Date</label>
            <input data-date-format="yyyy-mm-dd" id="start_date" class="form-control date" name="start_date" value="{{ old('start_date') }}" placeholder="Start Date" required autocomplete="off">
{{--            <input id="start_date" type="text" class="form-control" name="start_date" value="{{ old('start_date') }}" placeholder="5th April..." required>--}}
            @if ($errors->has('start_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('start_date') }}</strong>
                </span>
            @endif
        </div>

        <div class="col-md-12 form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
            <label>End Date</label>
            <input data-date-format="yyyy-mm-dd" id="end_date" class="form-control date" name="end_date" value="{{ old('end_date') }}" placeholder="End Date" required autocomplete="off">
{{--            <input id="end_date" type="text" class="form-control" name="end_date" value="{{ old('end_date') }}" placeholder="20th April..." required>--}}
            @if ($errors->has('end_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('end_date') }}</strong>
                </span>
            @endif
        </div>

        <div class="col-md-12 form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
            <label>For Class</label>
                <select id="book_code" class="form-control select2 classes-exams" multiple name="classes[]">
                    @foreach($classes as $class)
{{--                        <option value="{{$class->id}}">--}}
                            @if(in_array($class->id, $assigned_classes->pluck('class_id')->toArray()))
                                <option value="" disabled><b>Class - {{$class->class_number}}</b>&nbsp;&nbsp; <small>(Exam Assigned)</small></option>
                            @else
                                <option value="{{ $class->id}}"><b>Class - {{$class->class_number}}</b></option>
                            @endif
{{--                        </option>--}}
                    @endforeach
                </select>
{{--            <div style="margin-left: 50px;">--}}
{{--                @foreach ($classes as $class)--}}
{{--                    @if(in_array($class->id, $assigned_classes->pluck('class_id')->toArray()))--}}
{{--                        <div class="card-header mt-2">--}}
{{--                            <div class="checkbox">--}}
{{--                                Class : {{$class->class_number}} &nbsp;Already has assigned to Exam <b>--}}
{{--                                    @foreach($assigned_classes as $assigned_class)--}}
{{--                                        @if($assigned_class->class_id == $class->id)--}}
{{--                                            {{$assigned_class['exam']['exam_name']}}--}}
{{--                                            @break--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                </b>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @else--}}
{{--                        <div class="card-header mt-2">--}}
{{--                            <div class="form-check">--}}
{{--                                <input type="checkbox" class="form-check-input" name="classes[]" value="{{$class->id}}">--}}
{{--                                <label class="form-check-label"> Class: {{$class->class_number}}</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                @endforeach--}}

{{--            </div>--}}
            @if ($errors->has('classes'))
                <span class="help-block">
                    <strong>{{ $errors->first('classes') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-6 form-group mg-t-8">
            <button type="submit" class="button button--edit float-left"><b>Save</b></button>
            <a href="javascript:history.back()" class="button button--cancel" style="margin-left: 1%;" role="button"><b>Cancel</b></a>
        </div>
    </div>
</form>

<script>
    $(function () {
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            language: 'en'
        });
    })
</script>