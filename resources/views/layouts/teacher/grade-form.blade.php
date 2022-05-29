<div class="col-md-12 mt-5" id="grade-labels">
    <div class="row">
        @foreach(marking_subjects_quiz() as $item)
                <div class="col-md-2">
                    <div class="form-check form-check-inline">
                        <input id="{{ $item['id'] }}" type="checkbox" name="{{ $item['name'] }}" value="{{ $item['value'] }}" {{ $item['checked'] }}>
                        <label for="{{ $item['id'] }}">
                            <span class="{{ $item['class'] }} mr-4">{{ $item['text'] }}</span>
                        </label>
                    </div>
                </div>
        @endforeach
    </div>
    <div class="row">
        @foreach(marking_subjects_assignment() as $item)
            <div class="col-md-2">
                <div class="form-check form-check-inline">
                    <input id="{{ $item['id'] }}" type="checkbox" name="{{ $item['name'] }}" value="{{ $item['value'] }}" {{ $item['checked'] }}>
                    <label for="{{ $item['id'] }}">
                        <span class="{{ $item['class'] }} mr-4">{{ $item['text'] }}</span>
                    </label>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        @foreach(marking_subjects_ct() as $item)
            <div class="col-md-2">
                <div class="form-check form-check-inline">
                    <input id="{{ $item['id'] }}" type="checkbox" name="{{ $item['name'] }}" value="{{ $item['value'] }}" {{ $item['checked'] }}>
                    <label for="{{ $item['id'] }}">
                        <span class="{{ $item['class'] }} mr-4">{{ $item['text'] }}</span>
                    </label>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        @foreach(marking_subjects_subject() as $item)
            <div class="col-md-2">
                <div class="form-check form-check-inline">
                    <input id="{{ $item['id'] }}" type="checkbox" name="{{ $item['name'] }}" value="{{ $item['value'] }}" {{ $item['checked'] }}>
                    <label for="{{ $item['id'] }}">
                        <span class="{{ $item['class'] }} mr-4">{{ $item['text'] }}</span>
                    </label>
                </div>
            </div>
        @endforeach
    </div>
</div>
<br/>
<br/>
<form action="{{url('teacher/grades/save-grade')}}" method="POST">
    {{csrf_field()}}
    <input type="hidden" name="section_id" value="{{$section_id}}">
    <input type="hidden" name="course_id" value="{{$course_id}}">
    <input type="hidden" name="exam_id" value="{{$exam->id}}">
    <input type="hidden" name="teacher_id" value="{{$teacher_id}}">
    @foreach($gradesystems as $gs)
        <input type="hidden" name="grade_system_name" value="{{$gs->grade_system_name}}">
    @endforeach
    <div class="table-responsive">
        <table class="table table-condensed table-hover table-width" id="marking-table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Code</th>
                <th scope="col">Name</th>
                <th scope="col">Attendance</th>
                <th scope="col">Quiz 1</th>
                <th scope="col">Quiz 2</th>
                <th scope="col">Quiz 3</th>
                <th scope="col">Quiz 4</th>
                <th scope="col">Quiz 5</th>
                <th scope="col">Assignment 1</th>
                <th scope="col">Assignment 2</th>
                <th scope="col">Assignment 3</th>
                <th scope="col">CT 1</th>
                <th scope="col">CT 2</th>
                <th scope="col">CT 3</th>
                <th scope="col">CT 4</th>
                <th scope="col">CT 5</th>
                <th scope="col">Written</th>
                <th scope="col">MCQ</th>
                <th scope="col">Practical</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($grades as $grade)
                <input type="hidden" name="grade_ids[]" value="{{$grade->id}}">
                <tr>
                    <th scope="row">{{($loop->index + 1)}}</th>
                    <td>{{$grade->student['student_code']}}</td>
                    <td>{{$grade->student['name']}}</td>
                    <td>
                        <input type="number" name="attendance[]" class="form-control input-sm" placeholder="Attendance"
                               value="{{$grade->attendance}}">
                    </td>
                    <td>
                        <input type="number" name="quiz1[]" class="form-control input-sm input-sm" value="{{$grade->quiz1}}"
                               placeholder="Qz 1" max="20">
                    </td>
                    <td>
                        <input type="number" name="quiz2[]" class="form-control input-sm" value="{{$grade->quiz2}}"
                               placeholder="Qz 2">
                    </td>
                    <td>
                        <input type="number" name="quiz3[]" class="form-control input-sm" value="{{$grade->quiz3}}"
                               placeholder="Qz 3">
                    </td>
                    <td>
                        <input type="number" name="quiz4[]" class="form-control input-sm" value="{{$grade->quiz4}}"
                               placeholder="Qz 4">
                    </td>
                    <td>
                        <input type="number" name="quiz5[]" class="form-control input-sm" value="{{$grade->quiz5}}"
                               placeholder="Qz 5">
                    </td>
                    <td>
                        <input type="number" name="assign1[]" class="form-control input-sm" placeholder="Assignment 1"
                               value="{{$grade->assignment1}}">
                    </td>
                    <td>
                        <input type="number" name="assign2[]" class="form-control input-sm" placeholder="Assignment 2"
                               value="{{$grade->assignment2}}">
                    </td>
                    <td>
                        <input type="number" name="assign3[]" class="form-control input-sm" placeholder="Assignment 3"
                               value="{{$grade->assignment3}}">
                    </td>
                    <td>
                        <input type="number" name="ct1[]" class="form-control input-sm" placeholder="CT 1"
                               value="{{$grade->ct1}}">
                    </td>
                    <td>
                        <input type="number" name="ct2[]" class="form-control input-sm" placeholder="CT 2"
                               value="{{$grade->ct2}}">
                    </td>
                    <td>
                        <input type="number" name="ct3[]" class="form-control input-sm" placeholder="CT 3"
                               value="{{$grade->ct3}}">
                    </td>
                    <td>
                        <input type="number" name="ct4[]" class="form-control input-sm" placeholder="CT 4"
                               value="{{$grade->ct4}}">
                    </td>
                    <td>
                        <input type="number" name="ct5[]" class="form-control input-sm" placeholder="CT 5"
                               value="{{$grade->ct5}}">
                    </td>
                    <td>
                        <input type="number" name="written[]" class="form-control input-sm" placeholder="Written"
                               value="{{$grade->written}}">
                    </td>
                    <td>
                        <input type="number" name="mcq[]" class="form-control input-sm" placeholder="Mcq"
                               value="{{$grade->mcq}}">
                    </td>
                    <td>
                        <input type="number" name="practical[]" class="form-control input-sm" placeholder="Practical"
                               value="{{$grade->practical}}">
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="text-center">
        <button type="submit" class="button button--save float-right mr-2"><b>Submit</b></button>
    </div>
</form>

<script>
    $(function () {
        var i;
        for (i = 6; i < 21; i++) {
            if (i == 10 || i == 13)
                continue;
            $("#marking-table td:nth-child(" + i + "),#marking-table th:nth-child(" + i + ")").hide();
        }
        $(":checkbox").change(function () {
            if ($(this).is(':checked')) {
                $("#marking-table td:nth-child(" + $(this).val() + "), #marking-table th:nth-child(" + $(this).val() +
                    ")").show();
            } else {
                $("#marking-table td:nth-child(" + $(this).val() + "),#marking-table th:nth-child(" + $(this).val() +
                    ")").hide();
                $("#marking-table td:nth-child(" + $(this).val() + ")").find('input').val('0');
            }
        });
    });
</script>
