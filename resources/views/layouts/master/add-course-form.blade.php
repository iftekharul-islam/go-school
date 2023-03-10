<div class="collapse" id="collapseForNewCourse{{$section->id}}" style="margin-top:1%;">
    <div class="panel panel-default">
        <div class="panel-body">
            <form class="form-horizontal" action="{{url('admin/courses/store')}}" method="post">
                {{csrf_field()}}
                <input type="hidden" name="class_id" value="{{$class->id}}"/>
                <input type="hidden" name="section_id" value="{{$section->id}}"/>
                <div class="false-padding-bottom-form form-group">
                    <label for="courseName{{$section->id}}" class="col-sm-12 control-label false-padding-bottom">{{ __('text.course_name') }}</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="courseName{{$section->id}}" name="course_name"
                               placeholder="Course Name">
                    </div>
                </div>

                <div class="form-group false-padding-bottom-form">
                    <label for="assignTeacher{{$section->id}}" class="col-sm-12 control-label false-padding-bottom">{{ __('text.course_teacher') }}</label>
                    <div class="col-sm-12">
                        <select class="form-control" id="assignTeacher{{$section->id}}" name="teacher_id">
                            <option value="0" selected disabled>Select Teacher</option>
                            @if(count($teachers) > 0)
                                {{$teachers_of_this_school = $teachers->filter(function ($teacher) use ($school){
                                  return $teacher->school_id == $school->id;
                                })}}
                                @foreach($teachers_of_this_school as $teacher)
                                    <option value="{{$teacher->id}}"
                                            data-department="{{$teacher->department_name}}">{{$teacher->name}} {{$teacher->department_name}}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="form-group false-padding-bottom-form">
                    <label for="course_type{{$section->id}}" class="col-sm-12 control-label false-padding-bottom">{{ __('text.course_type') }}</label>
                    <div class="col-sm-12">
                        <select class="form-control" id="course_type{{$section->id}}" name="course_type">
                            <option value="core">Core</option>
                            <option value="elective">Elective</option>
                            <option value="optional">Optional</option>
                        </select>
                    </div>
                </div>
                <div class="form-group false-padding-bottom-form">
                    <label for="courseTime{{$section->id}}" class="col-sm-2 control-label false-padding-bottom">{{ __('text.course_time') }}</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="courseTime{{$section->id}}" name="course_time"
                               placeholder="Course Time">
                        <span id="helpBlock" class="help-block">Example: 12:50PM-01:40PM Sunday</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="button button--save float-right">{{ __('text.Submit') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('customjs')
    <script>
        $('#teacherDepartment{{$section->id}}').click(function () {
            $("#assignTeacher{{$section->id}} option").hide();
            {{--$("#assignTeacher{{$section->id}} option[data-department="+$(this).val()+"]").show();--}}
        });
    </script>
@endpush
