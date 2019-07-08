 <div class="table-responsive">
      <table class="table display table-data-div text-wrap">
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
            <th>Class</th>
            <th>Section</th>
            <th>All Students</th>
            <th>Section Students</th>
            <th>Action</th>
          @endif
          @foreach ($courses as $course)
            @if(!$student && ($course->teacher_id == Auth::user()->id || Auth::user()->role == 'admin') && $course->exam_id != 0)
              <th>Marks Submission</th>
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

            <td>{{$course->course_time}}</td>

            <td>{{$course->section->room_number}}</td>

            @if($student)
              <td>
                <a class="text-teal" href="{{url('user/'.$course->teacher->student_code)}}">{{$course->teacher->name}}</a>
              </td>
            @endif

            @if(!$student)
              <td>{{$course->section->class->class_number}}</td>
              <td>{{$course->section->section_number}}</td>

              @if($course->exam_id != 0)
                <td>
                  <a href="{{url('course/students/'.$course->teacher_id.'/'.$course->id.'/'.$course->exam_id.'/'.$course->section->id)}}" role="button" class="btn btn-info btn-lg">Message Students</a>
                </td>
                <td>
                  <a role="button"
                     class="btn btn-secondary btn-lg float-left"
                     href="{{url('section/students/'.$course->section->id.'?section=1')}}">View
                    Students</a>
                </td>
              @else
                <td>Save under Exam to Add Student</td>
              @endif

              @if(!$student && ($course->teacher_id == Auth::user()->id || Auth::user()->role == 'admin') && $course->exam_id != 0)
                <td>
                  <a href="{{url('attendances/students/'.$course->teacher_id.'/'.$course->id.'/'.$course->exam_id.'/'.$course->section->id)}}" role="button" class="btn btn-info btn-lg">Take Attendance</a>
                </td>
              @else
                <td>Save under Exam to Take Attendance</td>
              @endif

            @endif

            @if(!$student && ($course->teacher_id == Auth::user()->id || Auth::user()->role == 'admin') && $course->exam_id != 0)
              <td>
                <a href="{{url('grades/c/'.$course->teacher_id.'/'.$course->id.'/'.$course->exam_id.'/'.$course->section->id)}}" role="button" class="btn btn-secondary btn-lg ">Submit Grade</a>
              </td>
              <td>
                <a href="{{url('grades/t/'.$course->teacher_id.'/'.$course->id.'/'.$course->exam_id.'/'.$course->section->id)}}" role="button" class="btn btn-info btn-lg">View Marks</a>
              </td>
            @endif

            @if(Auth::user()->role == 'admin')
              <td>
                <a href="{{url('edit/course/'.$course->id)}}" class="button button--edit">Edit</a>
              </td>
            @endif
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>