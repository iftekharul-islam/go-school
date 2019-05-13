 <div class="table-responsive">
      <table class="table display data-table text-nowrap">
        <thead>
        <tr>
          <th>#</th>
          <th>Course Name</th>
          <th>Course Time</th>
          <th>Room Number</th>
          @if($student)
            <th>Course Teacher</th>
          @endif
          @if(!$student)
            <th>Class Number</th>
            <th>Section Number</th>
            <th>All Students</th>
            <th>Action</th>
          @endif
          @foreach ($courses as $course)
            @if(!$student && ($course->teacher_id == Auth::user()->id || Auth::user()->role == 'admin') && $course->exam_id != 0)
              <th>Give Marks</th>
              <th>View Marks</th>
            @endif
            @break
          @endforeach
          @if(Auth::user()->role == 'admin')
            <th>Edit</th>
          @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($courses as $course)
          <tr>
            <th scope="row">{{($loop->index + 1)}}</th>
            <td>
              {{$course->course_name}}
            </td>

            <td><small>{{$course->course_time}}</small></td>

            <td>{{$course->section->room_number}}</td>

            @if($student)
              <td>
                <a href="{{url('user/'.$course->teacher->student_code)}}">{{$course->teacher->name}}</a>
              </td>
            @endif

            @if(!$student)
              <td>{{$course->section->class->class_number}}</td>
              <td>{{$course->section->section_number}}</td>

              @if($course->exam_id != 0)
                <td>
                  <a href="{{url('course/students/'.$course->teacher_id.'/'.$course->id.'/'.$course->exam_id.'/'.$course->section->id)}}" role="button" class="btn btn-info btn-xs"><i class="material-icons">message</i> Message Students</a>
                </td>
              @else
                <td><small>Save under Exam to Add Student</small></td>
              @endif

              @if(!$student && ($course->teacher_id == Auth::user()->id || Auth::user()->role == 'admin') && $course->exam_id != 0)
                <td>
                  <a href="{{url('attendances/students/'.$course->teacher_id.'/'.$course->id.'/'.$course->exam_id.'/'.$course->section->id)}}" role="button" class="btn btn-primary btn-xs"><i class="material-icons">spellcheck</i> Take Attendance</a>
                </td>
              @else
                <td><small>Save under Exam to Take Attendance</small></td>
              @endif

            @endif

            @if(!$student && ($course->teacher_id == Auth::user()->id || Auth::user()->role == 'admin') && $course->exam_id != 0)
              <td>
                <a href="{{url('grades/c/'.$course->teacher_id.'/'.$course->id.'/'.$course->exam_id.'/'.$course->section->id)}}" role="button" class="btn btn-danger btn-xs"><i class="material-icons">assessment</i> Submit Grade</a>
              </td>
              <td>
                <a href="{{url('grades/t/'.$course->teacher_id.'/'.$course->id.'/'.$course->exam_id.'/'.$course->section->id)}}" role="button" class="btn btn-success btn-xs"><i class="material-icons">bar_chart</i> View Marks</a>
              </td>
            @endif

            @if(Auth::user()->role == 'admin')
              <td>
                <a href="{{url('edit/course/'.$course->id)}}" class="btn btn-xs btn-danger"><i class="material-icons">edit</i> Edit</a>
              </td>
            @endif
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>