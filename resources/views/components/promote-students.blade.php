<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet">
<div class="table-responsive">
    <form action="{{url('admin/school/promote-students')}}" method="post" class="new-added-form">
        {{ csrf_field() }}
        <input type="hidden" name="section_id" value="{{$section_id}}">
        <table class="table display text-nowrap border">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ __('text.Code') }}</th>
                <th>{{ __('text.Name') }}</th>
                <th>{{ __('text.left_school') }}</th>
                <th>{{ __('text.from_session') }}</th>
                <th>{{ __('text.to_session') }}</th>
                <th>{{ __('text.from_session') }}</th>
                <th>{{ __('text.Section') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($students as $key=>$student)
                <tr>
                    <th>{{ ($loop->index + 1) }}</th>
                    <td>{{$student->student_code}}</td>
                    <td>
                        <a class="text-teal" href="{{url('user/'.$student->student_code)}}">{{$student->name}}</a>
                    </td>
                    <td>
                        <div class="form-check">
                            <input type="checkbox" name="left_school{{$loop->index}}">
                            <label class="form-check-label">Left</label>
                        </div>
                    </td>
                    <td>
                        {{$student->studentInfo['session']}}
                    </td>
                    <td>
                        <input data-date-format="yyyy" class="form-control date" name="to_session[]" id="datepicker"
                               value="{{date('Y', strtotime('+1 year'))}}">
                    </td>
                    <td>
                        Class: {{$student->section->class->class_number}} - Section:
                        {{$student->section->section_number}}
                    </td>
                    <td>
                        <select id="to_section" class="form-control" name="to_section[]">
                            @foreach($classes as $class)
                                @foreach($class->sections as $section)
                                    @if($student->section->class->class_number === $class->class_number && $student->section->section_number === $section->section_number)
                                        <option value="{{$section->id}}" selected>
                                            Class: {{$class->class_number}} - Section: {{$section->section_number}}
                                        </option>
                                    @else
                                        <option value="{{$section->id}}">
                                            Class: {{$class->class_number}} - Section: {{$section->section_number}}
                                        </option>
                                    @endif
                                @endforeach
                            @endforeach
                        </select>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div style="text-align:center;" class="mt-5">
            <input type="submit" class="button button--save float-right" value="Submit">
        </div>
    </form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function () {
        $('.date').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
    })

</script>
