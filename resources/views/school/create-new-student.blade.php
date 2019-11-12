<form class="new-added-form" method="POST" id="registerForm"
      enctype="multipart/form-data"
      action="{{ route('register.student.store') }}">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="name"
                           class="control-label false-padding-bottom">Full
                        Name<label class="text-danger">*</label></label>
                    <input id="na   me" type="text" class="form-control"
                           name="name" value="{{ old('name') }}"
                           required>

                    @if ($errors->has('name'))
                        <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="email"
                           class="control-label false-padding-bottom">E-Mail
                        Address<label
                                class="text-danger">*</label></label>

                    <input id="email" type="email" class="form-control"
                           name="email" value=""
                           required>

                    @if ($errors->has('email'))
                        <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="password"
                           class="control-label false-padding-bottom">Password<label
                                class="text-danger">*</label></label>
                    <input id="password" type="password"
                           class="form-control" name="password"
                           required>

                    @if ($errors->has('password'))
                        <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group">

                <div class="col-md-12">
                    <label for="password-confirm"
                           class="control-label false-padding-bottom">Confirm
                        Password<label
                                class="text-danger">*</label></label>

                    <input id="password-confirm" type="password"
                           class="form-control"
                           name="password_confirmation" required>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('department') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="department"
                           class=" control-label false-padding-bottom">Department</label>

                    <select id="department" class="form-control"
                            name="department_id">
                        <option value="" selected> --Select Option-- </option>
                        @if (count($departments) > 0)
                            @foreach ($departments as $department)
                                <option value="{{$department->id}}">{{$department->department_name}}</option>
                            @endforeach
                        @endif
                    </select>

                    @if ($errors->has('department'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('department') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('section') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="section"
                           class="control-label false-padding-bottom">Class
                        and Section<label class="text-danger">*</label></label>

                    <select id="section" class="form-control"
                            name="section" required>
                        @foreach ($studentSections as $section)
                            <option value="{{$section->id}}">
                                Section: {{$section->section_number}}
                                Class:
                                {{$section->class->class_number}}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('section'))
                        <span class="help-block"><strong>{{ $errors->first('section') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('version') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="version"
                           class="control-label false-padding-bottom">Version<label
                                class="text-danger">*</label></label>

                    <select id="version" class="form-control"
                            name="version">
                        <option selected="selected">Bangla</option>
                        <option>English</option>
                    </select>

                    @if ($errors->has('version'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('version') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('session') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="session"
                           class="control-label false-padding-bottom">Session<label
                                class="text-danger">*</label></label>

                    <input id="session" type="text" class="form-control"
                           name="session"
                           value=""
                           required>

                    @if ($errors->has('session'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('session') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('group') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="group"
                           class=" control-label false-padding-bottom">Group
                        (Optional)</label>

                    <input id="group" type="text" class="form-control"
                           name="group"
                           value="{{ old('group') }}"
                           placeholder="Science, Arts, Commerce,etc.">

                    @if ($errors->has('group'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('group') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="phone_number"
                           class="control-label false-padding-bottom">Phone
                        Number<label
                                class="text-danger">*</label></label>

                    <input id="phone_number" type="text"
                           class="form-control" name="phone_number"
                           value="{{ old('phone_number') }}">

                    @if ($errors->has('phone_number'))
                        <span class="help-block"><strong>{{ $errors->first('phone_number') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="birthday"
                           class="control-label false-padding-bottom">Birthday<label
                                class="text-danger">*</label></label>

                    <input data-date-format="yyyy-mm-dd" id="birthday"
                           class="form-control date" name="birthday"
                           value="{{ old('birthday') }}"
                           placeholder="Birthday" required
                           autocomplete="off">

                    @if ($errors->has('birthday'))
                        <span class="help-block"><strong>{{ $errors->first('birthday') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">

            <div class="false-padding-bottom-form form-group{{ $errors->has('blood_group') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="blood_group"
                           class=" control-label false-padding-bottom">Blood
                        Group<label
                                class="text-danger">*</label></label>

                    <select id="blood_group" class="form-control"
                            name="blood_group">
                        <option selected="selected">A+</option>
                        <option>A-</option>
                        <option>B+</option>
                        <option>B-</option>
                        <option>AB+</option>
                        <option>AB-</option>
                        <option>O+</option>
                        <option>O-</option>
                    </select>

                    @if ($errors->has('blood_group'))
                        <span class="help-block"><strong>{{ $errors->first('blood_group') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('nationality') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="nationality"
                           class=" control-label false-padding-bottom">Nationality<label
                                class="text-danger">*</label></label>

                    <input id="nationality" type="text"
                           class="form-control" name="nationality"
                           value=""
                           required>

                    @if ($errors->has('nationality'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('nationality') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('gender') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="gender"
                           class="control-label false-padding-bottom">Gender</label>

                    <select id="gender" class="form-control"
                            name="gender">
                        <option class="text-capitalize" value="male"
                                selected="selected">Male
                        </option>
                        <option class="text-capitalize" value="female">
                            Female
                        </option>
                    </select>

                    @if ($errors->has('gender'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>


    </div>
    <div class="row">

        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('religion') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="religion"
                           class=" control-label false-padding-bottom">Religion<label
                                class="text-danger">*</label></label>

                    <select id="religion" class="form-control"
                            name="religion">
                        <option selected="selected">Islam</option>
                        <option>Hinduism</option>
                        <option>Christianism</option>
                        <option>Buddhism</option>
                        <option>Other</option>
                    </select>

                    @if ($errors->has('religion'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('religion') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('address') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="address"
                           class="control-label false-padding-bottom">Address<label
                                class="text-danger">*</label></label>

                    <input id="address" type="text" class="form-control"
                           name="address"
                           value=""
                           required>

                    @if ($errors->has('address'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('father_name') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="father_name"
                           class=" control-label false-padding-bottom">Father's
                        Name<label class="text-danger">*</label></label>

                    <input id="father_name" type="text"
                           class="form-control" name="father_name"
                           value=""
                           required>

                    @if ($errors->has('father_name'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('father_name') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('father_phone_number') ? ' has-error' : '' }}">


                <div class="col-md-12">
                    <label for="father_phone_number"
                           class="control-label false-padding-bottom">Father's
                        Phone
                        Number<label
                                class="text-danger">*</label></label>
                    <input id="father_phone_number" type="text"
                           class="form-control"
                           name="father_phone_number"
                           value="">

                    @if ($errors->has('father_phone_number'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('father_phone_number') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('father_national_id') ? ' has-error' : '' }}">


                <div class="col-md-12">
                    <label for="father_national_id"
                           class="control-label false-padding-bottom">Father's
                        National
                        ID<label class="text-danger">*</label></label>
                    <input id="father_national_id" type="text"
                           class="form-control"
                           name="father_national_id"
                           value="{{ old('father_national_id') }}">

                    @if ($errors->has('father_national_id'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('father_national_id') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('father_occupation') ? ' has-error' : '' }}">


                <div class="col-md-12">
                    <label for="father_occupation"
                           class=" control-label false-padding-bottom">Father's
                        Occupation</label>
                    <input id="father_occupation" type="text"
                           class="form-control"
                           name="father_occupation">

                    @if ($errors->has('father_occupation'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('father_occupation') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('father_annual_income') ? ' has-error' : '' }}">


                <div class="col-md-12">
                    <label for="father_annual_income"
                           class="control-label false-padding-bottom">Father's
                        Annual
                        Income</label>
                    <input id="father_annual_income" type="text"
                           class="form-control"
                           name="father_annual_income">

                    @if ($errors->has('father_annual_income'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('father_annual_income') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('father_designation') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="father_designation"
                           class=" control-label false-padding-bottom">Father's
                        Designation</label>

                    <input id="father_designation" type="text"
                           class="form-control"
                           name="father_designation"
                    >

                    @if ($errors->has('father_designation'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('father_designation') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('mother_phone_number') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="mother_phone_number"
                           class="control-label false-padding-bottom">Mother's
                        Phone
                        Number</label>

                    <input id="mother_phone_number" type="text"
                           class="form-control"
                           name="mother_phone_number"
                    >

                    @if ($errors->has('mother_phone_number'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('mother_phone_number') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('mother_name') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="mother_name"
                           class=" control-label false-padding-bottom">Mother's
                        Name<label class="text-danger">*</label></label>

                    <input id="mother_name" type="text"
                           class="form-control" name="mother_name"
                           value=""
                           required>

                    @if ($errors->has('mother_name'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('mother_name') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('mother_occupation') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="mother_occupation"
                           class="control-label false-padding-bottom">Mother's
                        Occupation</label>

                    <input id="mother_occupation" type="text"
                           class="form-control"
                           name="mother_occupation"
                           value="">

                    @if ($errors->has('mother_occupation'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('mother_occupation') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('mother_national_id') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="mother_national_id"
                           class=" control-label false-padding-bottom">Mother's
                        National
                        ID<label class="text-danger">*</label></label>

                    <input id="mother_national_id" required type="text"
                           class="form-control"
                           name="mother_national_id"
                           value="">

                    @if ($errors->has('mother_national_id'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('mother_national_id') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('mother_designation') ? ' has-error' : '' }}">


                <div class="col-md-12">
                    <label for="mother_designation"
                           class="control-label false-padding-bottom">Mother's
                        Designation</label>
                    <input id="mother_designation" type="text"
                           class="form-control"
                           name="mother_designation"
                    >

                    @if ($errors->has('mother_designation'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('mother_designation') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('mother_annual_income') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="mother_annual_income"
                           class=" control-label false-padding-bottom">Mother's
                        Annual
                        Income</label>
                    <input id="mother_annual_income" type="text"
                           class="form-control"
                           name="mother_annual_income"
                    >

                    @if ($errors->has('mother_annual_income'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('mother_annual_income') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="false-padding-bottom-form form-group{{ $errors->has('about') ? ' has-error' : '' }}">

                <div class="col-md-12">
                    <label for="about"
                           class=" control-label false-padding-bottom">About</label>

                    <textarea id="about" class="form-control"
                              name="about">{{ old('about') }}</textarea>

                    @if ($errors->has('about'))
                        <span class="help-block">
                                    <strong>{{ $errors->first('about') }}</strong>
                                </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">

        <div class="col-md-12">
            <label class=" control-label">Upload Profile
                Picture</label>
            <input type="file" id="picPath" name="student_pic">
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-12 col-md-offset-4">
            <button type="submit" id="registerBtn"
                    class="button button--save float-right">
                Register
            </button>
        </div>
    </div>
</form>