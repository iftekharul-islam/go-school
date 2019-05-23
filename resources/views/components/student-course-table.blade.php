<table class="table table-data-div display text-nowrap">
  <thead>
  <tr>
    <th>
      <div class="form-check">
        <input type="checkbox" class="form-check-input checkAll">
        <label class="form-check-label">ID</label>
      </div>
    </th>
    <th>Course Name</th>
    <th>Course Time</th>
    <th>Room Number</th>
    <th>Class Teacher</th>
    <th></th>
  </tr>
  </thead>
  <tbody>

  @foreach($courses as $key=>$course)
    <tr>
      <td>
        <div class="form-check">
          <input type="checkbox" class="form-check-input">
          <label class="form-check-label">{{ $key++ }}</label>
        </div>
      </td>
      <td>{{ $course->course_name }}</td>
      <td>{{ $course->course_time }}</td>
      <td>{{ $course->section->room_number }}</td>
      <td><a href="{{url('user/'.$course->teacher->student_code)}}">{{$course->teacher->name}}</a></td>
      <td>
        <div class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"
             aria-expanded="false">
            <span class="flaticon-more-button-of-three-dots"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="#"><i
                      class="fas fa-times text-orange-red"></i>Close</a>
            <a class="dropdown-item" href="#"><i
                      class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
            <a class="dropdown-item" href="#"><i
                      class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
          </div>
        </div>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>