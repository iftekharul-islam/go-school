<div class="card height-auto">
  <div class="card-body">
    <div class="heading-layout1">
      <div class="item-title">
        <h3>{{$user->name}} <span class="badge badge-danger">{{ucfirst($user->role)}}</span> <span class="badge badge-secondary">{{ucfirst($user->gender)}}</span>
          @if ($user->role == 'teacher' && $user->section_id > 0)
            <small>Class Teacher of Section: <span class="badge badge-primary">{{ucfirst($user->section->section_number)}}</span></small>
          @endif
        </h3>
      </div>
      <div class="dropdown">
        <a class="dropdown-toggle" href="#" role="button"
           data-toggle="dropdown" aria-expanded="false">...</a>

        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
          <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
          <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
        </div>
      </div>
    </div>
    <div class="single-info-details">
      <div class="row">
        <div class="col-md-3">
          <div class="item-img">
            <img src="{{ $user->pic_path  }}" alt="student">
          </div>
        </div>
        <div class="col-md-9">
          <div class="item-content">
            <div class="header-inline item-header">
              <div class="header-elements">
                <ul>
                  <li><a href="#"><i class="far fa-edit"></i></a></li>
                  <li><a href="#"><i class="fas fa-print"></i></a></li>
                  <li><a href="#"><i class="fas fa-download"></i></a></li>
                </ul>
              </div>
            </div>

            @if($user->role == "student")
              <div class="info-table table-responsive">
                <table class="table text-nowrap">
                  <tr>
                    <td>Student ID:</td>
                    <td class="font-medium text-dark-medium">{{$user->student_code}}</td>
                    <td>Student's Name:</td>
                    <td class="font-medium text-dark-medium">{{$user->name}}</td>
                  </tr>
                  <tr>
                    <td>Class:</td>
                    <td class="font-medium text-dark-medium">{{$user->section->class->class_number}}</td>
                    <td>Section:</td>
                    <td class="font-medium text-dark-medium">{{$user->section->section_number}}</td>
                  </tr>
                  <tr>
                    <td>Session:</td>
                    <td class="font-medium text-dark-medium">{{$user->studentInfo['session']}}</td>
                    <td>Version:</td>
                    <td class="font-medium text-dark-medium">{{$user->studentInfo['version']}}</td>
                  </tr>
                  <tr>
                    <td>Group:</td>
                    <td class="font-medium text-dark-medium">{{$user->studentInfo['group']}}</td>
                    {{--                <td colspan="2"></td>--}}
                  </tr>
                  <tr>
                    <td>Email:</td>
                    <td class="font-medium text-dark-medium">{{$user->email}}</td>
                    <td>Contact Number</td>
                    <td class="font-medium text-dark-medium">{{$user->phone_number}}</td>
                  </tr>
                  <tr>
                    <td>Gender:</td>
                    <td class="font-medium text-dark-medium">{{$user->gender}}</td>
                    <td>Blood Group:</td>
                    <td class="font-medium text-dark-medium">{{$user->blood_group}}</td>
                  </tr>
                  <tr>
                    <td>Nationality:</td>
                    <td class="font-medium text-dark-medium">{{$user->nationality}}</td>
                    <td>Birthday:</td>
                    <td class="font-medium text-dark-medium">{{Carbon\Carbon::parse($user->birthday)->format('d/m/Y')}}</td>
                  </tr>
                  <tr>
                    <td>Religion:</td>
                    <td class="font-medium text-dark-medium">{{$user->studentInfo['religion']}}</td>
                    <td>Father Name:</td>
                    <td class="font-medium text-dark-medium">{{$user->studentInfo['father_name']}}</td>
                  </tr>
                  <tr>
                    <td>Mother Name:</td>
                    <td class="font-medium text-dark-medium">{{$user->studentInfo['mother_name']}}</td>
                    <td>Address:</td>
                    <td class="font-medium text-dark-medium">{{$user->address}}</td>
                  </tr>
                  <tr>
                    <td>Phone Number:</td>
                    <td class="font-medium text-dark-medium">{{$user->phone_number}}</td>
                    <td>Father's Phone Number:</td>
                    <td class="font-medium text-dark-medium">{{$user->studentInfo['father_phone_number']}}</td>
                  </tr>
                  <tr>
                    <td>Father's National ID:</td>
                    <td class="font-medium text-dark-medium">{{$user->studentInfo['father_national_id']}}</td>
                    <td>Father's Occupation:</td>
                    <td class="font-medium text-dark-medium">{{$user->studentInfo['father_occupation']}}</td>
                  </tr>
                  <tr>
                    <td>Father's Designation:</td>
                    <td class="font-medium text-dark-medium">{{$user->studentInfo['father_designation']}}</td>
                    <td>Father's Annual Income:</td>
                    <td class="font-medium text-dark-medium">{{$user->studentInfo['father_annual_income']}}</td>
                  </tr>
                  <tr>
                    <td>Mother's Phone Number:</td>
                    <td class="font-medium text-dark-medium">{{$user->studentInfo['mother_phone_number']}}</td>
                    <td>Mother's National ID:</td>
                    <td class="font-medium text-dark-medium">{{$user->studentInfo['mother_national_id']}}</td>
                  </tr>
                  <tr>
                    <td >Mother's Occupation:</td>
                    <td class="font-medium text-dark-medium">{{$user->studentInfo['mother_occupation']}}</td>
                    <td>Mother's Designation:</td>
                    <td class="font-medium text-dark-medium">{{$user->studentInfo['mother_designation']}}</td>
                  </tr>
                  <tr>
                    <td>Mother's Annual Income:</td>
                    <td class="font-medium text-dark-medium">{{$user->studentInfo['mother_annual_income']}}</td>
                  </tr>
                </table>
              </div>
            @endif

            @if($user->role == "teacher" || $user->role == "accountant" || $user->role == "librarian" )
              <div class="info-table table-responsive">
                <table class="table text-nowrap">
                  <tr>
                    <td><b>Code:</b></td>
                    <td>{{$user->student_code}}</td>
                    <td><b>About:</b></td>
                    <td>{{$user->about}}</td>
                  </tr>
                  <tr>
                    <td><b>Nationality:</b></td>
                    <td>{{$user->nationality}}</td>
                    <td><b>Religion:</b></td>
                    <td>{{$user->studentInfo['religion']}}</td>
                  </tr>

                  <tr>
                    <td><b>Address:</b></td>
                    <td>{{$user->address}}</td>
                    <td><b>Phone Number:</b></td>
                    <td>{{$user->phone_number}}</td>

                  </tr>
                </table>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
