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
                                        <td class="text-nowrap">Student ID:</td>
                                        <td class="font-medium text-dark-medium">{{$user->student_code}}</td>

                                    </tr>
                                    <tr>
                                        <td class="text-nowrap">Version:</td>
                                        <td class="font-medium text-dark-medium">{{$user->studentInfo['version']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap">Gender:</td>
                                        <td class="font-medium text-dark-medium">{{$user->gender}}</td>

                                    </tr>
                                    <tr>
                                        <td>Nationality:</td>
                                        <td class="font-medium text-dark-medium">{{$user->nationality}}</td>

                                    </tr>
                                    <tr>
                                        <td>Religion:</td>
                                        <td class="font-medium text-dark-medium">{{$user->studentInfo['religion']}}
                                        </td>

                                    </tr>
                                    <tr>
                                        <td>Address:</td>
                                        <td class="font-medium text-dark-medium">{{$user->address}}</td>
                                    </tr>
                                    <tr>
                                        <td>Father Name:</td>
                                        <td class="font-medium text-dark-medium">{{$user->studentInfo['father_name']}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap">Father's Phone Number:</td>
                                        <td class="font-medium text-dark-medium">
                                            {{$user->studentInfo['father_phone_number']}}</td>
                                    </tr>
                                    <tr>
                                        <td>Father's National ID:</td>
                                        <td class="font-medium text-dark-medium">
                                            {{$user->studentInfo['father_national_id']}}</td>

                                    </tr>
                                    <tr>
                                        <td>Father's Occupation:</td>
                                        <td class="font-medium text-dark-medium">
                                            {{$user->studentInfo['father_occupation']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap">Father's Annual Income:</td>
                                        <td class="font-medium text-dark-medium">
                                            {{$user->studentInfo['father_annual_income']}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap">Father's Designation:</td>
                                        <td class="font-medium text-dark-medium">{{$user->studentInfo['father_designation']}}</td>

                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-table table-responsive">
                                <table class="text-wrap table-borderless table">
                                    <tr>
                                        <td>Class:</td>
                                        <td class="font-medium text-dark-medium">{{$user->section->class->class_number}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Section:</td>
                                        <td class="font-medium text-dark-medium">{{$user->section->section_number}}</td>
                                    </tr>
                                    <tr>
                                        <td>Session:</td>
                                        <td class="font-medium text-dark-medium">{{$user->studentInfo['session']}}</td>

                                    </tr>
                                    <tr>
                                        <td>Group:</td>
                                        <td class="font-medium text-dark-medium">{{$user->studentInfo['group']}}</td>
                                        {{--                <td colspan="2"></td>--}}
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td class="font-medium text-dark-medium">{{$user->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Contact Number</td>
                                        <td class="font-medium text-dark-medium">{{$user->phone_number}}</td>
                                    </tr>
                                    <tr>
                                        <td>Blood Group:</td>
                                        <td class="font-medium text-dark-medium">{{$user->blood_group}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap">Mother Name:</td>
                                        <td class="font-medium text-dark-medium">{{$user->studentInfo['mother_name']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap">Mother's Phone Number:</td>
                                        <td class="font-medium text-dark-medium">
                                            {{$user->studentInfo['mother_phone_number']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap">Mother's National ID:</td>
                                        <td class="font-medium text-dark-medium">
                                            {{$user->studentInfo['mother_national_id']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap">Mother's Occupation:</td>
                                        <td class="font-medium text-dark-medium">
                                            {{$user->studentInfo['mother_occupation']}}</td>

                                    </tr>
                                    <tr>
                                        <td class="text-nowrap">Mother's Annual Income:</td>
                                        <td class="font-medium text-dark-medium">
                                            {{$user->studentInfo['mother_annual_income']}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-nowrap">Mother's Designation:</td>
                                        <td class="font-medium text-dark-medium">
                                            {{$user->studentInfo['mother_designation']}}</td>
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
                            <td>Name:</td>
                            <td class="font-medium text-dark-medium">{{$user->name}}</td>
                          </tr>
                          <tr>
                            <td>User Type:</td>
                            <td class="font-medium text-dark-medium">{{$user->role}}</td>
                          </tr>
                          <tr>
                            <td>Gender:</td>
                            <td class="font-medium text-dark-medium">{{ $user->gender }}</td>
                          </tr>
                          <tr>
                            <td>Religion:</td>
                            <td class="font-medium text-dark-medium">{{$user->studentInfo['religion']}}</td>
                          </tr>
                          <tr>
                            <td>E-mail:</td>
                            <td class="font-medium text-dark-medium">{{ $user->email }}</td>
                          </tr>
                            <td>Class Teacher:</td>
                            <td class="font-medium text-dark-medium">{{ ucfirst( $user->section->class_id ) }}</td>
                          </tr>
                          <tr>
                            <td>Section:</td>
                            <td class="font-medium text-dark-medium">{{ ucfirst($user->section->section_number)}}</td>
                          </tr>
                          <tr>
                            <td>Code:</td>
                            <td class="font-medium text-dark-medium">{{$user->student_code}}</td>
                          </tr>
                          <tr>
                            <td>Address:</td>
                            <td class="font-medium text-dark-medium">{{$user->address}}</td>
                          </tr>
                          <tr>
                            <td>Phone:</td>
                            <td class="font-medium text-dark-medium">{{$user->phone_number}}</td>
                          </tr>
                          <tr>
                            <td>About: </td>
                            <td class="font-medium text-dark-medium">{{$user->about}}</td>
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
