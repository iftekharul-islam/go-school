<table class="table table-data-div display text-nowrap">
  <thead>
  <tr>
    <th>#</th>
    <th>Course Name</th>
    <th>Room Number</th>
    <th>Class Time</th>
    <th>Class Teacher</th>
  </tr>
  </thead>
  <tbody>

  @foreach($courses as $key=>$course)
    <tr>
      <td>
        {{ $key++ }}
      </td>
      <td>{{ $course->course_name }}</td>
      <td>{{ $course->section->room_number }}</td>
      <td>{{ $course->course_time }}</td>
      <td><a href="{{url('user/'.$course->teacher->student_code)}}">{{$course->teacher->name}}</a></td>
    </tr>
  @endforeach
  </tbody>
</table>