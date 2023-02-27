@extends('layouts.student-app')

@section('title', 'Edit School')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            Edit School
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Schools</li>
            <li><a href="{{ route('all.school') }}">All School</a></li>
            <li>Edit School</li>
        </ul>
    </div>
    @if (session('status'))
        <div class="alert alert-success mb-3">
            {{ session('status') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card height-auto false-height">
                <div class="card-body">
                    <form class="form-horizontal" enctype="multipart/form-data" method="POST"
                          action="{{ url('master/school/edit', $school->id) }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="row">
                                    <div
                                        class="mb-4 col-md-12 form-group{{ $errors->has('school_name') ? ' has-error' : '' }}">
                                        <label for="school_name" class="control-label">School Name</label>

                                        <input id="school_name" type="text" class="form-control" name="school_name"
                                               value="{{ $school->name }}" placeholder="School Name" required>

                                        @if ($errors->has('school_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('school_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div
                                        class="mb-4 col-md-6 form-group{{ $errors->has('school_medium') ? ' has-error' : '' }}">
                                        <label for="school_medium" class="control-label">School Medium</label>

                                        <select id="school_medium" class="select2" name="school_medium">
                                            <option {{ $school->medium == 'Bangla' ? 'selected' : '' }}>Bangla</option>
                                            <option {{ $school->medium == 'English' ? 'selected' : '' }}>English
                                            </option>
                                            <option {{ $school->medium == 'Bangla & English' ? 'selected' : '' }}>Bangla
                                                & English
                                            </option>
                                        </select>

                                        @if ($errors->has('school_medium'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('school_medium') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div
                                        class="mb-4 col-md-6 form-group{{ $errors->has('school_established') ? ' has-error' : '' }}">
                                        <label for="school_established" class="control-label">School Established</label>
                                        <input readonly="readonly" value="{{ $school->established }}"
                                               data-date-format="yyyy-mm-dd" id="birthday"
                                               class="form-control date" name="school_established"
                                               placeholder="School Established" required
                                               autocomplete="off">
                                        @if ($errors->has('school_established'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('school_established') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div
                                        class="mb-4 col-md-6 form-group{{ $errors->has('district') ? ' has-error' : '' }}">
                                        <label for="district" class="control-label">District <label class="text-danger">*</label></label>
                                        <select id="district" class="form-control select2" name="district" required>
                                            <option value="">Select District</option>
                                            @if(config('districts.districts'))
                                                @foreach ( config('districts.districts') as $district)
                                                    <option value="{{$district}}"
                                                            @if($school->district == $district) selected @endif>{{ $district }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if ($errors->has('district'))
                                            <span
                                                class="help-block"><strong>{{ $errors->first('district') }}</strong></span>
                                        @endif
                                    </div>
                                    <div
                                        class="mb-4 col-md-6 form-group{{ $errors->has('payment_type') ? ' has-error' : '' }}">
                                        <label for="payment_type" class="control-label">Payment Type <label
                                                class="text-danger">*</label></label>
                                        <select id="payment_type" class="form-control select2" name="payment_type"
                                                required>
                                            <option value="" selected>Select Payment Type</option>
                                            <option value="monthly"
                                                    @if ($school->payment_type == 'monthly') selected @endif>Monthly
                                            </option>
                                            <option value="per_student"
                                                    @if ($school->payment_type == 'per_student') selected @endif>Per
                                                Student
                                            </option>
                                        </select>
                                        @if ($errors->has('payment_type'))
                                            <span
                                                class="help-block"><strong>{{ $errors->first('payment_type') }}</strong></span>
                                        @endif
                                    </div>
                                    <div
                                        class="mb-4 col-md-6 form-group{{ $errors->has('charge') ? ' has-error' : '' }}">
                                        <label for="charge" class="control-label false-padding-bottom">Charge <label
                                                class="text-danger">*</label></label>
                                        <input id="charge" type="text" class="form-control" name="charge"
                                               value="{{$school->charge}}" required>
                                        @if ($errors->has('charge'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('charge') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div
                                        class="mb-4 col-md-6 form-group{{ $errors->has('school_address') ? ' has-error' : '' }}">
                                        <label for="school_address" class="control-label">Address <label
                                                class="text-danger">*</label></label>

                                        <textarea id="school_address" class="form-control" rows="3"
                                                  name="school_address"
                                                  placeholder="School Address"
                                                  required>{{ $school->school_address }}</textarea>

                                        @if ($errors->has('school_address'))
                                            <span
                                                class="help-block"><strong>{{ $errors->first('school_address') }}</strong></span>
                                        @endif
                                    </div>
                                    <div
                                        class="mb-4 col-md-12 form-group{{ $errors->has('school_about') ? ' has-error' : '' }}">
                                        <label for="school_about" class="control-label">About</label>
                                        <textarea id="school_about" class="form-control" rows="3" name="school_about"
                                                  placeholder="About School" required>{{ $school->about }}</textarea>
                                        @if ($errors->has('school_about'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('school_about') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                    <div
                                        class="mb-4 col-md-12 form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                                        <label for="logo" class="control-label">School Logo</label>

                                        <input id="logo" type="file" class="form-control" name="logo">

                                        @if ($errors->has('logo'))
                                            <span
                                                class="help-block"><strong>{{ $errors->first('logo') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 ">
                                <fieldset class="scheduler-border border border-secondary p-4">
                                    <legend class="scheduler-border">Configuration</legend>
                                    <div class="row">
                                        <div
                                            class="mb-4 col-md-6 form-group{{ $errors->has('is_sms_enable') ? ' has-error' : '' }}">
                                            <label for="is_sms_enable" class="control-label">SMS Option <label
                                                    class="text-danger">*</label></label>
                                            <select id="is_sms_enable" class="form-control"
                                                    onchange="smsChargeFieldValidation()" name="is_sms_enable" required>
                                                <option value="" disabled>SMS Option</option>
                                                <option value="1" @if($school->is_sms_enable == 1) selected @endif>
                                                    Enable
                                                </option>
                                                <option value="0" @if($school->is_sms_enable === 0) selected @endif>
                                                    Disable
                                                </option>
                                            </select>
                                            @if ($errors->has('is_sms_enable'))
                                                <span
                                                    class="help-block"><strong>{{ $errors->first('is_sms_enable') }}</strong></span>
                                            @endif
                                        </div>
                                        <div
                                            class="mb-4 col-md-6 form-group{{ $errors->has('sms_charge') ? ' has-error' : '' }}">
                                            <label for="sms_charge" class="control-label false-padding-bottom">SMS
                                                Charge(Per SMS) <label class="text-danger">*</label></label>
                                            <input id="sms_charge" type="text" class="form-control" name="sms_charge"
                                                   value="{{$school->sms_charge}}" placeholder="0.35"
                                                   @if($school->is_sms_enable == 1) required @endif>
                                            @if ($errors->has('sms_charge'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('sms_charge') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div
                                            class="mb-4 col-md-12 form-group{{ $errors->has('online_class_sms') ? ' has-error' : '' }}">
                                            <label for="online_class_sms" class="control-label">Online Class SMS</label>
                                            <select id="online_class_sms" class="form-control" name="online_class_sms">
                                                <option value="" disabled>SMS Option</option>
                                                <option value="1"
                                                        @if($school->online_class_sms === true) selected @endif>Enable
                                                </option>
                                                <option value="0"
                                                        @if($school->online_class_sms === false) selected @endif>Disable
                                                </option>
                                            </select>
                                            @if ($errors->has('online_class_sms'))
                                                <span
                                                    class="help-block"><strong>{{ $errors->first('online_class_sms') }}</strong></span>
                                            @endif
                                        </div>
                                        <div
                                            class="mb-4 col-md-12 form-group{{ $errors->has('invoice_generation_date') ? ' has-error' : '' }}">
                                            <label for="invoice_generation_date"
                                                   class="control-label false-padding-bottom">Invoice Generation
                                                Date</label>
                                            <select id="invoice_generation_date" class="form-control select2"
                                                    name="invoice_generation_date">
                                                <option disabled selected>Select Date</option>
                                                @for($i = 1; $i <= 31; $i++)
                                                    <option value="{{$i}}"
                                                            @if($school->invoice_generation_date == $i) selected @endif>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            @if ($errors->has('invoice_generation_date'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('invoice_generation_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div
                                            class="mb-4 col-md-12 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label for="email" class="control-label false-padding-bottom">Email</label>
                                            <input id="email" type="text" class="form-control" name="email"
                                                   value="{{$school->email}}" placeholder="Email">
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div
                                            class="mb-4 col-md-12 form-group{{ $errors->has('due_date') ? ' has-error' : '' }}">
                                            <label for="due_date" class="control-label false-padding-bottom">Payment Due
                                                Date</label>
                                            <select id="due_date" class="form-control select2" name="due_date">
                                                <option disabled selected>Due Date</option>
                                                @for($i = 1; $i <= 31; $i++)
                                                    <option value="{{$i}}"
                                                            @if($school->due_date == $i) selected @endif>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            @if ($errors->has('due_date'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('due_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div
                                            class=" col-md-12 form-group{{ $errors->has('signup_date') ? ' has-error' : '' }}">
                                            <label for="signup_date" class="control-label false-padding-bottom">Signup
                                                Date</label>
                                            <input id="signup_date" data-date-format="yyyy-mm-dd" type="text"
                                                   class="form-control date" name="signup_date"
                                                   value="{{$school->singup_date}}" autocomplete="off">
                                            @if ($errors->has('signup_date'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('signup_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-md-12 mt-5">
                                <button type="submit" id="registerBtn" class="button button--save float-right"><i
                                        class="fas fa-edit mr-2"></i>Update
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customjs')
    <script>
        function smsChargeFieldValidation() {
            if ($('#is_sms_enable').val() == 1) {
                $('#sms_charge').attr('required', 'required');
            } else {
                $('#sms_charge').removeAttr('required');
            }
        }
    </script>
@endpush
