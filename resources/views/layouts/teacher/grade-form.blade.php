<style>
    #grade-labels > .label {
        margin-right: 1%;
    }

    .table-width tbody tr td {
        min-width: 80px;
    }
    .min-area {
        min-width: 175px;
    }
</style>
<div class="col-md-12 mt-5" id="grade-labels">
    <div class="row">
        <div class="form-check form-check-inline">
            <input id="checkbox1" type="checkbox" name="attendance" value="4" checked>
            <label for="checkbox1">
                <span class="badge badge-primary">Attendance</span>
            </label>
        </div>

        <div class="form-check form-check-inline">
            <input id="checkbox2" type="checkbox" name="quiz[]" value="5" checked>
            <label for="checkbox2">
                <span class="badge badge-primary"> Quiz 1</span>
            </label>
        </div>

        <div class="form-check form-check-inline">
            <input id="checkbox3" type="checkbox" name="quiz[]" value="6">
            <label for="checkbox3">
                <span class="badge badge-primary">Quiz 2</span>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input id="checkbox4" type="checkbox" name="quiz[]" value="7">
            <label for="checkbox4">
                <span class="badge badge-primary">Quiz 3</span>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input id="checkbox5" type="checkbox" name="quiz[]" name="quiz[]" value="8">
            <label for-="checkbox5">
                <span class="badge badge-primary">Quiz 4</span>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input id="checkbox6" type="checkbox" name="quiz[]" value="9">
            <label for-="checkbox6">
                <span class="badge badge-primary">Quiz 5</span>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input id="checkbox7" type="checkbox" name="assignment[]" value="10" checked>
            <label for="checkbox7" class="min-area">
                <span class="badge badge-success">Assignment 1</span>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input id="checkbox8" type="checkbox" name="assignment[]" value="11">
            <label for="checkbox8" class="min-area">
                <span class="badge badge-success">Assignment 2</span>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input id="checkbox9" type="checkbox" name="assignment[]" value="12">
            <label for="checkbox9" class="min-area">
                <span class="badge badge-success">Assignment 3</span>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input id="checkbox10" type="checkbox" name="ct[]" value="13" checked>
            <label for="checkbox10" class="min-area">
                <span class="badge badge-info">Class Test 1</span>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input id="checkbox11" type="checkbox" name="ct[]" value="14">
            <label for="checkbox11" class="min-area">
                <span class="badge badge-info">Class Test 2</span>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input id="checkbox12" type="checkbox" name="ct[]" value="15">
            <label for="checkbox12" class="min-area">
                <span class="badge badge-info">Class Test 3</span>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input id="checkbox13" type="checkbox" name="ct[]" value="16">
            <label for="checkbox13" class="min-area">
                <span class="badge badge-info">Class Test 4</span>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input id="checkbox14" type="checkbox" name="ct[]" value="17">
            <label for="checkbox14" class="min-area">
                <span class="badge badge-info">Class Test 5</span>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input id="checkbox16" type="checkbox" name="few" value="18">
            <label for="checkbox16" class="min-area">
                <span class="badge badge-secondary">Final Exam Written</span>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input id="checkbox17" type="checkbox" name="fem" value="19">
            <label for="checkbox17" class="min-area">
                <span class="badge badge-secondary">Final Exam MCQ</span>
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input id="checkbox18" type="checkbox" name="fem" value="20">
            <label for="checkbox18" class="min-area">
                <span class="badge badge-warning">Practical</span>
            </label>
        </div>
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
                        <input type="number" name="quiz1[]" class="form-control input-sm input-sm"
                               value="{{$grade->quiz1}}"
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
