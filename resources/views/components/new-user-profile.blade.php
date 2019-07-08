<!-- <div class="heading-layout1">
      <div class="item-title">
        <h3>{{$user->name}} <span class="badge badge-danger">{{ucfirst($user->role)}}</span> <span class="badge badge-secondary ml-2">{{ucfirst($user->gender)}}</span>
          @if ($user->role == 'teacher' && $user->section_id > 0)
    <small class="ml-5">Class Teacher of Section: <span class="badge badge-primary">{{ucfirst($user->section->section_number)}}</span></small>
          @endif
        </h3>
      </div>
    </div> -->
<div class="single-info-details">
    <div class="row">
        <div class="col-md-3">
            <div class="item-img-round">
                @if(!empty($user->pic_path))
                    <img src="{{url($user->pic_path)}}" data-src="{{url($user->pic_path)}}" class="" id="my-profile"
                         alt="Profile Picture" width="100%">
                @else
                    @if(strtolower($user->gender) == 'male')
                        <img src="{{asset('01-progress.gif')}}"
                             data-src="https://png.icons8.com/dusk/200/000000/user.png"
                             class="img-thumbnail" width="100%">
                    @else
                        <img src="{{asset('01-progress.gif')}}"
                             data-src="https://png.icons8.com/dusk/200/000000/user-female.png" class="img-thumbnail"
                             width="100%">
                    @endif
                @endif
            </div>
            <div class="item-content">

            @if($user->role == "student")

                <!-- <td>Student's Name:</td> -->
                    <div class="profile-name">
                        <h3 class="">{{$user->name}}</h3>
                    </div>
                    <div class="info-table table-responsive">
                        <table class="text-nowrap table-borderless table ">
                            <tr>
                                <td class="font-medium text-dark-medium">Email :</td>
                                <td class="text-left">{{$user->email}}</td>
                            </tr>
                            <tr>
                                <td class="font-medium text-dark-medium">Contact Number :</td>
                                <td class="text-left">{{$user->phone_number}}</td>
                            </tr>

                            <tr>
                                <td class="font-medium text-dark-medium">Birthday :</td>
                                <td class="text-left">
                                    {{Carbon\Carbon::parse($user->birthday)->format('d/m/Y')}}</td>
                            </tr>
                        </table>
                    </div>
                @endif
            </div>

        </div>
        <div class="col-md-9">
            <div class="item-content">
                @if($user->role == "student")
                    <div class="row mg-t-60">
                        <div class="col-md-6">
                            <div class="info-table table-responsive border-right">
                                <table class="text-wrap table-borderless table ">
                                    <tr>
                                        <td class="text-nowrap font-medium text-dark-medium">Student ID:</td>
                                        <td class="text-capitalize">{{$user->student_code}}</td>

                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Version:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['version']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Gender:</td>
                                        <td class="text-capitalize">{{$user->gender}}</td>

                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Nationality:</td>
                                        <td class="text-capitalize">{{$user->nationality}}</td>

                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Religion:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['religion']}}</td>

                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Address:</td>
                                        <td class="text-capitalize">{{$user->address}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Father Name:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['father_name']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Father's Phone Number:</td>
                                        <td >{{$user->studentInfo['father_phone_number']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Father's National ID:</td>
                                        <td>{{$user->studentInfo['father_national_id']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Father's Occupation:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['father_occupation']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Father's Annual Income:</td>
                                        <td>{{$user->studentInfo['father_annual_income']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Father's Designation:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['father_designation']}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-table table-responsive">
                                <table class="text-wrap table-borderless table">
                                    <tr>
                                        <td class="font-medium text-dark-medium">Class:</td>
                                        <td>{{$user->section->class->class_number}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Section:</td>
                                        <td class="text-capitalize">{{$user->section->section_number}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Session:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['session']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Group:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['group']}}</td>
                                        {{--                <td colspan="2"></td>--}}
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Email:</td>
                                        <td >{{$user->email}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Contact Number</td>
                                        <td>{{$user->phone_number}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Blood Group:</td>
                                        <td class="text-capitalize">{{$user->blood_group}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Mother Name:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['mother_name']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Mother's Phone Number:</td>
                                        <td>{{$user->studentInfo['mother_phone_number']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Mother's National ID:</td>
                                        <td class="font-medium text-dark-medium">{{$user->studentInfo['mother_national_id']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Mother's Occupation:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['mother_occupation']}}</td>

                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Mother's Annual Income:</td>
                                        <td>{{$user->studentInfo['mother_annual_income']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium">Mother's Designation:</td>
                                        <td class="text-capitalize">{{$user->studentInfo['mother_designation']}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                  @endif
                    @if($user->role == "teacher" || $user->role == "accountant" || $user->role == "librarian" || $user->role == "admin" )

                      <div class="info-table table-responsive">
                        <table class="table text-wrap">
                          <tbody>
                          <tr>
                            <td class="font-medium text-dark-medium">Name:</td>
                            <td >{{$user->name}}</td>
                          </tr>
                          <tr>
                            <td class="font-medium text-dark-medium">User Type:</td>
                            <td class="text-capitalize">{{$user->role}}</td>
                          </tr>
                          <tr>
                            <td class="font-medium text-dark-medium">Gender:</td>
                            <td class="text-capitalize">{{ $user->gender }}</td>
                          </tr>

                          <tr>
                            <td class="font-medium text-dark-medium">E-mail:</td>
                            <td>{{ $user->email }}</td>
                          </tr>
                          <tr>
                              @if($user->role === 'teacher')
                                  <tr>
                                      <td class="font-medium text-dark-medium">Section:</td>
                                      <td class="text-capitalize">{{ ucfirst($user->section->section_number)}}</td>
                                  </tr>
                                  <tr>
                                      <td class="font-medium text-dark-medium">Class Teacher:</td>
                                      <td class="text-capitalize">{{ ucfirst( $user->section->class_id ) }}</td>
                                  </tr>
                              @endif
                          </tr>
                          <tr>
                            <td class="font-medium text-dark-medium">Address:</td>
                            <td>{{$user->address}}</td>
                          </tr>
                          <tr>
                            <td class="font-medium text-dark-medium">Phone:</td>
                            <td>{{$user->phone_number}}</td>
                          </tr>
                          <tr>
                            <td class="font-medium text-dark-medium">About: </td>
                            <td>{{$user->about}}</td>
                          </tr>
                          </tbody>
                        </table>
                      </div>

{{--                      <div class="table-responsive">--}}
{{--                        <table class="table text-wrap">--}}
{{--                          <tr>--}}
{{--                            <td><b>Code:</b></td>--}}
{{--                            <td>{{$user->student_code}}</td>--}}
{{--                            <td><b>About:</b></td>--}}
{{--                            <td>{{$user->about}}</td>--}}
{{--                          </tr>--}}
{{--                          <tr>--}}
{{--                            <td><b>Nationality:</b></td>--}}
{{--                            <td>{{$user->nationality}}</td>--}}
{{--                            <td><b>Religion:</b></td>--}}
{{--                            <td>{{$user->studentInfo['religion']}}</td>--}}
{{--                          </tr>--}}

{{--                          <tr>--}}
{{--                            <td><b>Address:</b></td>--}}
{{--                            <td>{{$user->address}}</td>--}}
{{--                            <td><b>Phone Number:</b></td>--}}
{{--                            <td>{{$user->phone_number}}</td>--}}

{{--                          </tr>--}}
{{--                        </table>--}}
{{--                      </div>--}}
                    @endif
                </div>
              </div>
            </div>
          </div>
