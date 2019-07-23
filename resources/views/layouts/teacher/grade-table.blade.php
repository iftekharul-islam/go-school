<div class="table-responsive">
  <table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>#</th>
      <th>Student Code</th>
      <th>Student Name</th>
      <th>Attendance</th>
        @for($i=1;$i<=5;$i++)
          <th>Quiz {{$i}}</th>
        @endfor
        @for($i=1;$i<=3;$i++)
          <th>Assignment {{$i}}</th>
        @endfor
        @for($i=1;$i<=5;$i++)
          <th>CT {{$i}}</th>
        @endfor
        @if($grade->course->final_exam_percent > 0)
          <th>Written</th>
          <th>Mcq</th>
        @endif
        @if($grade->course->practical_percent > 0)
          <th>Practical</th>
        @endif
      <th>Total Marks</th>
      <th>GPA</th>
      <th>Grade</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($grades as $grade)
    <tr>
      <th>{{($loop->index + 1)}}</th>
      <td>{{$grade->student->student_code}}</td>
      <td><a href="{{url('user/'.$grade->student->student_code)}}">{{$grade->student->name}}</a></td>
      <td>{{$grade->attendance}}</td>
      @for($i=1;$i<=5;$i++)
        <td>{{$grade['quiz'.$i]}}</td>
      @endfor
      @for($i=1;$i<=3;$i++)
        <td>{{$grade['assignment'.$i]}}</td>
      @endfor
      @for($i=1;$i<=5;$i++)
        <td>{{$grade['ct'.$i]}}</td>
      @endfor
      @if($grade->course->final_exam_percent > 0)
        <td>{{$grade->written}}</td>
        <td>{{$grade->mcq}}</td>
      @endif
      @if($grade->course->practical_percent > 0)
        <td>{{$grade->practical}}</td>
      @endif
      <td>{{$grade->marks}}</td>
      <td>{{$grade->gpa}}</td>
      <td>
        @foreach($gradesystems as $gs)
          @if(isset($gs->grade_points))
            @if($gs->grade_points == $grade->gpa)
              {{$gs->grade}}
              @break
            @endif
          @endif
        @endforeach
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
