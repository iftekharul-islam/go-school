<form class="new-added-form" action="{{url('exams/create')}}" method="post">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-8 form-group{{ $errors->has('term') ? ' has-error' : '' }}">
            <label>Terms</label>
            <select id="term" class="select2" name="term">
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


        <div class="col-md-8 form-group{{ $errors->has('exam_name') ? ' has-error' : '' }}">
            <label>Examination Name</label>
            <input id="exam_name" type="text" class="form-control" name="exam_name" value="{{ old('exam_name') }}" placeholder="Semester 1 Exam 2018, Final Exam 2019, ..." required>

            @if ($errors->has('exam_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('exam_name') }}</strong>
                </span>
            @endif
        </div>


        <div class="col-md-8 form-group{{ $errors->has('term') ? ' has-error' : '' }}">
            <label>Start Date</label>
            <input id="start_date" type="text" class="form-control" name="start_date" value="{{ old('start_date') }}" placeholder="5th April..." required>
            @if ($errors->has('start_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('start_date') }}</strong>
                </span>
            @endif
        </div>

        <div class="col-md-8 form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
            <label>End Date</label>
            <input id="end_date" type="text" class="form-control" name="end_date" value="{{ old('end_date') }}" placeholder="20th April..." required>
            @if ($errors->has('end_date'))
                <span class="help-block">
                    <strong>{{ $errors->first('end_date') }}</strong>
                </span>
            @endif
        </div>

        <div class="col-md-8 form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
            <label>For Class</label>
            <div style="margin-left: 100px;">
                @foreach ($classes as $class)
                    @if(in_array($class->id, $assigned_classes->pluck('class_id')->toArray()))
                        <div class="checkbox">
                            {{$class->class_number}} already assigned to Exam <b>
                                @foreach($assigned_classes as $assigned_class)
                                    @if($assigned_class->class_id == $class->id)
                                        {{$assigned_class->exam->exam_name}}
                                        @break
                                    @endif
                                @endforeach
                            </b>
                        </div>
                    @else
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="classes[]" value="{{$class->id}}">
                            <label class="form-check-label">{{$class->class_number}}</label>
                        </div>
                    @endif
                @endforeach

            </div>
            @if ($errors->has('classes'))
                <span class="help-block">
                    <strong>{{ $errors->first('classes') }}</strong>
                </span>
            @endif
        </div>
        <div class="col-12 form-group mg-t-8">
            <a href="javascript:history.back()" class="btn btn-danger" style="margin-right: 2%;" role="button">Cancel</a>
            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
        </div>
    </div>
</form>