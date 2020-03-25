<table class="table table-data-div table-bordered display text-nowrap">
  <thead>
  <tr>
    <th>#</th>
    <th>Course Name</th>
    <th>Room Number</th>
    <th>Class Time</th>
    <th>Class Teacher</th>
    @if(Auth::user()->role == 'admin')
        <th>Action</th>
    @endif
  </tr>
  </thead>
  <tbody>

  @foreach($courses as $key=>$course)
    <tr>
      <td>
        {{ $loop->index+1  }}
      </td>
      <td>{{ $course->course_name }}</td>
      <td>{{ $course->section->room_number }}</td>
      <td>{{ $course->course_time }}</td>
      <td>
        @if ( !empty($course->teacher['student_code']) )
          <a class="text-teal" href="{{url('user/'.$course->teacher['student_code'])}}">{{ $course->teacher['name'] }}</a>
        @else
          {{ $course->teacher['name'] }}
        @endif
      </td>
        @if(Auth::user()->role == 'admin')
            <td>
                <a href="{{url('admin/edit/course/'.$course->id)}}" role="button" class="btn btn-primary btn-lg"><i class="far fa-edit"></i></a>
            </td>
        @endif
    </tr>
  @endforeach
  </tbody>
</table>
