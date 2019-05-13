{{--{{$users->links()}}--}}
<div class="breadcrumbs-area">
  <h3>Dashboard</h3>
  <ul>
    <li>
      <a href="{{ url('/home') }}">Home</a>
    </li>
    @if(count($users) > 0)
      @foreach ($users as $user)
        <li>{{ucfirst($user->role)}}s</li>
        @break($loop->first)
      @endforeach
    @endif
  </ul>
</div>
<!-- Breadcubs Area End Here -->
<!-- Student Table Area Start Here -->
<div class="card height-auto">
  <div class="card-body">
    <div class="heading-layout1">
      <div class="item-title">
        <h3>All Students Data</h3>
      </div>
      <div class="dropdown">
        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
           aria-expanded="false">...</a>

        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="#"><i
                    class="fas fa-times text-orange-red"></i>Close</a>
          <a class="dropdown-item" href="#"><i
                    class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
          <a class="dropdown-item" href="#"><i
                    class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
        </div>
      </div>
    </div>
    <form class="mg-b-20">
      <div class="row gutters-8">
        <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
          <input type="text" placeholder="Search by Roll ..." class="form-control">
        </div>
        <div class="col-4-xxxl col-xl-4 col-lg-3 col-12 form-group">
          <input type="text" placeholder="Search by Name ..." class="form-control">
        </div>
        <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
          <input type="text" placeholder="Search by Class ..." class="form-control">
        </div>
        <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
          <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
        </div>
      </div>
    </form>
    <div class="table-responsive">
      <table class="table display data-table text-nowrap">
        <thead>
        <tr>
          <th scope="col">#</th>
          @if(Auth::user()->role == 'admin')
            @if (!Session::has('section-attendance'))
              <th scope="col">Action</th>
            @endif
          @endif
          <th>Code</th>
          <th>Full Name</th>
          @foreach ($users as $user)
            @if($user->role == 'student')
              @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
                <th scope="col">Attendance</th>
              @endif
              @if (!Session::has('section-attendance'))
                <th>Session</th>
                <th>Version</th>
                <th>Class</th>
                <th>Section</th>
                <th>Father</th>
                <th>Mother</th>
              @endif
            @elseif($user->role == 'teacher')
              @if (!Session::has('section-attendance'))
                <th>Email</th>
                @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
                  <th>Courses</th>
                @endif
              @endif
            @elseif($user->role == 'accountant' || $user->role == 'librarian')
              @if (!Session::has('section-attendance'))
                <th>Email</th>
              @endif
            @endif
            @break($loop->first)
          @endforeach
          @if (!Session::has('section-attendance'))
            <th>Gender</th>
            <th>Blood</th>
            <th>Phone</th>
            <th>Address</th>
          @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $key=>$user)
          <tr>
            <th scope="row">{{ ($current_page-1) * $per_page + $key + 1 }}</th>
            @if(Auth::user()->role == 'admin')
              @if (!Session::has('section-attendance'))
                <td>
                  <a class="btn btn-xs btn-danger" href="{{url('edit/user/'.$user->id)}}">Edit</a>
                </td>
              @endif
            @endif
            <td>{{$user->student_code}}</td>
            <td>

                @if(!empty($user->pic_path))
{{--                  <img src="{{asset('01-progress.gif')}}" data-src="{{url($user->pic_path)}}" style="border-radius: 50%;" width="25px" height="25px">--}}
                @else
                  @if(strtolower($user->gender) == 'male')
                    <img src="{{asset('01-progress.gif')}}" data-src="https://png.icons8.com/dusk/50/000000/user.png" style="border-radius: 50%;" width="25px" height="25px">&nbsp;
                  @else
                    <img src="{{asset('01-progress.gif')}}" data-src="https://png.icons8.com/dusk/50/000000/user-female.png" style="border-radius: 50%;" width="25px" height="25px">&nbsp;
                  @endif
                @endif
                <a href="{{url('user/'.$user->student_code)}}">
                  {{$user->name}}</a>
              </td>
            @if($user->role == 'student')
              @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
                <td><a class="btn btn-xs btn-info" role="button" href="{{url('attendances/0/'.$user->id.'/0')}}">View Attendance</a></td>
              @endif
              @if (!Session::has('section-attendance'))
                <td>{{$user->studentInfo['session']}}</td>
                <td>{{ucfirst($user->studentInfo['version'])}}</td>
                <td>{{$user->section->class->class_number}} {{!empty($user->group)? '- '.$user->group:''}}</td>
                <td style="white-space: nowrap;">{{$user->section->section_number}}
                </td>
                <td>{{$user->studentInfo['father_name']}}</td>
                <td>{{$user->studentInfo['mother_name']}}</td>
              @endif
            @elseif($user->role == 'teacher')
              @if (!Session::has('section-attendance'))
                <td>
                  {{$user->email}}
                </td>
                @if(Auth::user()->role == 'student' || Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
                  <td style="white-space: nowrap;">

                      <a href="{{url('courses/'.$user->id.'/0')}}">All Courses</a>

                  </td>
                @endif
              @endif
            @elseif($user->role == 'accountant' || $user->role == 'librarian')
              @if (!Session::has('section-attendance'))
                <td>
                  {{$user->email}}
                </td>
              @endif
            @endif
            @if (!Session::has('section-attendance'))
              <td>{{ucfirst($user->gender)}}</td>
              <td>{{$user->blood_group}}</td>
              <td>{{$user->phone_number}}</td>
              <td>{{$user->address}}</td>
            @endif
          </tr>
        @endforeach
        </tbody>
      </table>
  </div>
</div>

</div>