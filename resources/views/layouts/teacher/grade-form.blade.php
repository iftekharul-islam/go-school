{{--<div class="well" style="font-size: 15px;">Choose Field to Display</div>--}}
<style>
  #grade-labels > .label{
    margin-right: 1%;
  }
</style>
<div class="col-md-12 text-center" id="grade-labels">
  <div class="row">
    <div class="col-12 font-size-20">
      <input type="checkbox" class="form-group ml-5 mr-3" name="attendance" value="4" checked>
      <span class="badge  badge-light checkbox-inline mr-1">
    Attendance
  </span>
      <input type="checkbox" class="form-group ml-5 mr-3" name="quiz[]" value="5" checked>
      <span class="badge badge-primary checkbox-inline mr-1">
    Quiz 1
  </span>
      <input type="checkbox" class="form-group ml-5 mr-3" name="quiz[]" value="6">
      <span class="badge badge-primary checkbox-inline mr-1">
  Quiz 2
  </span>
      <input type="checkbox" class="form-group ml-5 mr-3" name="quiz[]" value="7">
      <span class="badge badge-primary mr-1 checkbox-inline">
  Quiz 3
  </span>
      <input type="checkbox" class="form-group ml-5 mr-3" name="quiz[]" value="8">
      <span class="badge badge-primary mr-1 checkbox-inline">
  Quiz 4
  </span>
      <input type="checkbox" class="form-group ml-5 mr-3" name="quiz[]" value="9">
      <span class="badge badge-primary mr-1 checkbox-inline">
  Quiz 5
  </span>
      <input type="checkbox"  class="form-group ml-5 mr-3" name="assignment[]" value="10" checked>
      <span class="badge badge-success mr-1 checkbox-inline">
  Assignment 1
  </span>
      <input type="checkbox" class="form-group ml-5 mr-3" name="assignment[]" value="11">
      <span class="badge badge-success mr-1 checkbox-inline">
  Assignment 2
  </span>
      <input type="checkbox" class="form-group ml-5 mr-3" name="assignment[]" value="12">
      <span class="badge badge-success mr-1 checkbox-inline">
  Assignment 3
  </span>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-12 font-size-20">
      <input type="checkbox" class="form-group ml-5 mr-3" name="ct[]" value="13" checked>
      <span class="badge badge-info mr-1 checkbox-inline">
    Class Test 1
  </span>
      <input type="checkbox" class="form-group ml-5 mr-3" name="ct[]" value="14">
      <span class="badge badge-info mr-1 checkbox-inline">
    Class Test 2
  </span>
      <input type="checkbox" class="form-group ml-5 mr-3" name="ct[]" value="15">
      <span class="badge badge-info mr-1 checkbox-inline">
    Class Test 3
  </span>
      <input type="checkbox" class="form-group ml-5 mr-3" name="ct[]" value="16">
      <span class="badge badge-info mr-1 checkbox-inline">
    Class Test 4
  </span>
      <input type="checkbox" class="form-group ml-5 mr-3" name="ct[]" value="17">
      <span class="badge badge-info mr-1 checkbox-inline">
    Class Test 5
  </span>
      <input type="checkbox" class="form-group ml-5 mr-3" name="few" value="18">
      <span class="badge badge-secondary mr-1 checkbox-inline">
    Final Exam Written
  </span>
      <input type="checkbox" class="form-group ml-5 mr-3" name="fem" value="19">
      <span class="badge badge-secondary mr-1 checkbox-inline">
    Final Exam MCQ
  </span>
      <input type="checkbox" class="form-group ml-5 mr-3" name="practical" value="20">
      <span class="badge badge-warning mr-1 checkbox-inline">
    Practical
  </span>
    </div>
  </div>
</div>
<br />
<br />
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
    <table class="table table-condensed table-hover" id="marking-table">
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
          <td>{{$grade->student->student_code}}</td>
          <td>{{$grade->student->name}}</td>
          <td>
            <input type="number" name="attendance[]" class="form-control input-sm" placeholder="Attendance" value="{{$grade->attendance}}">
          </td>
          <td>
            <input type="number" name="quiz1[]" class="form-control input-sm input-sm" value="{{$grade->quiz1}}"
                   placeholder="Qz 1" max="20">
          </td>
          <td>
            <input type="number" name="quiz2[]" class="form-control input-sm" value="{{$grade->quiz2}}" placeholder="Qz 2">
          </td>
          <td>
            <input type="number" name="quiz3[]" class="form-control input-sm" value="{{$grade->quiz3}}" placeholder="Qz 3">
          </td>
          <td>
            <input type="number" name="quiz4[]" class="form-control input-sm" value="{{$grade->quiz4}}" placeholder="Qz 4">
          </td>
          <td>
            <input type="number" name="quiz5[]" class="form-control input-sm" value="{{$grade->quiz5}}" placeholder="Qz 5">
          </td>
          <td>
            <input type="number" name="assign1[]" class="form-control input-sm" placeholder="Assignment 1" value="{{$grade->assignment1}}">
          </td>
          <td>
            <input type="number" name="assign2[]" class="form-control input-sm" placeholder="Assignment 2" value="{{$grade->assignment2}}">
          </td>
          <td>
            <input type="number" name="assign3[]" class="form-control input-sm" placeholder="Assignment 3" value="{{$grade->assignment3}}">
          </td>
          <td>
            <input type="number" name="ct1[]" class="form-control input-sm" placeholder="CT 1" value="{{$grade->ct1}}">
          </td>
          <td>
            <input type="number" name="ct2[]" class="form-control input-sm" placeholder="CT 2" value="{{$grade->ct2}}">
          </td>
          <td>
            <input type="number" name="ct3[]" class="form-control input-sm" placeholder="CT 3" value="{{$grade->ct3}}">
          </td>
          <td>
            <input type="number" name="ct4[]" class="form-control input-sm" placeholder="CT 4" value="{{$grade->ct4}}">
          </td>
          <td>
            <input type="number" name="ct5[]" class="form-control input-sm" placeholder="CT 5" value="{{$grade->ct5}}">
          </td>
          <td>
            <input type="number" name="written[]" class="form-control input-sm" placeholder="Written" value="{{$grade->written}}">
          </td>
          <td>
            <input type="number" name="mcq[]" class="form-control input-sm" placeholder="Mcq" value="{{$grade->mcq}}">
          </td>
          <td>
            <input type="number" name="practical[]" class="form-control input-sm" placeholder="Practical" value="{{$grade->practical}}">
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
  <div style="text-align:center;">
    <button type="submit" class="button button--save float-right mr-2"><b>Submit</b></button>
    {{--    <input type="submit" name="save" class="button button--save float-right mr-2" value="Submit">--}}
  </div>
</form>

<script>
  $(function () {
    var i;
    for ( i = 6; i < 21; i++) {
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
      }
    });
  });
</script>