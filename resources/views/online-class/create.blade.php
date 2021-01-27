@extends('layouts.student-app')

@section('title', 'Create Class Schedule')

@section('content')
    <style>
        .for-repeatable {
            display: none;
        }

        .Week-check {
            display: block;
        }

        .everyday_time {
            display: none;
        }

        .example {
            width: 100%;
        }
        .false-padding-bottom-form .sms-area textarea {
            height: initial;
        }
    </style>

    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>
                Create Schedule
            </h3>
            <ul>
                <li>
                    <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                        {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;"
                       href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
                </li>
                <li>Create Schedule</li>
            </ul>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
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
        <div class="false-height">
            <div class="card mb-3">
                <div class="card-body">
                    <form class="new-added-form" action="{{ route('class.schedule.create') }}" method="get">
                        {{ csrf_field() }}
                        <input type="hidden" id="section_id" name="section_id" value="">
                        <div class="row">
                            <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                <label>{{ __('text.Class') }}</label>
                                <select name="class" id="class_number" class="select2" onchange="getSections(this.value)">
                                    <option>Select Class</option>
                                    @foreach($classes as $class)
                                        <option
                                            value="{{ $class->id }}" {{ $class->class_number ==  $class_number ? 'selected' : '' }}>
                                            class - {{ $class->class_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                <label>{{ __('text.Section') }}</label>
                                <select class="select2" id="section" name="section"></select>
                            </div>
                            <div class="col-12 form-group mg-t-2">
                                <label class="form-check-label" for="url">Online class URL</label>
                                <input type="url" name="url"
                                       class="form-control" placeholder="Enter url ..." value="{{ $url ?? '' }}">
                            </div>
                            <div class="col-12 form-group mg-t-2 float-right">
                                <button type="submit"
                                        class="button--save button float-right">{{ __('text.Search') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card height-auto">
                <div class="card-body">
                    @if(count($students) > 0)
                        <h4>Students of <b>Class:</b> {{ $class_number ?? ''}}
                            <b>Section:</b> {{ $section_number ?? '' }}
                            <b>Total students:</b> {{ count($students) }} </h4>

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="responsive">
                                                <table class="table table-data-div table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Student Code</th>
                                                        <th>Student Name</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($students as $student)
                                                        <tr>
                                                            <td>{{$student->student_code}}</td>
                                                            <td><a href="{{url('user/'.$student->student_code)}}"
                                                                   class="text-teal">{{$student->name}}</a></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            {{ $students->links() }}
                                        </div>
                                        <div class="col-md-12">
                                            <form id="final-form" action="{{ route('class.schedule.store') }}"
                                                  method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="sec_id" value="{{ $section_id }}">

{{--                                                Repeatable functionality--}}

{{--                                                <input type="hidden" id="schedule" name="schedule" value="">--}}

{{--                                                <div class="row mb-3">--}}
{{--                                                    <div class="offset-9 col-3 text-right">--}}
{{--                                                        <div class="form-check mr-4">--}}
{{--                                                            <input type="checkbox" name="is_repeatable"--}}
{{--                                                                   class="form-check-input Is_repeat"--}}
{{--                                                                   id="is_repeatable">--}}
{{--                                                            <label class="form-check-label" for="is_repeatable">Is--}}
{{--                                                                Repeatable </label>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="for-repeatable">--}}
{{--                                                    <div class="row">--}}
{{--                                                        <div class="col-md-12">--}}
{{--                                                            <div class="form-check">--}}
{{--                                                                <input type="checkbox" name="is_everyday"--}}
{{--                                                                       class="form-check-input" id="is_everyday">--}}
{{--                                                                <label class="form-check-label" for="is_everyday">Is--}}
{{--                                                                    Everyday</label>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="Week-check">--}}
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col-md-12">--}}
{{--                                                                <table class="table table-borderless" id="dynamicTable">--}}
{{--                                                                    <tr>--}}
{{--                                                                        <th>Week day</th>--}}
{{--                                                                        <th>Notification time</th>--}}
{{--                                                                    </tr>--}}
{{--                                                                    <tr>--}}
{{--                                                                        <td>--}}
{{--                                                                            <select id="week_day"--}}
{{--                                                                                    class="form-control example select2"--}}
{{--                                                                                    name="week_day[]">--}}
{{--                                                                                <option value="">Select a weekday--}}
{{--                                                                                </option>--}}
{{--                                                                                <option value="0">Sunday</option>--}}
{{--                                                                                <option value="1">Montday</option>--}}
{{--                                                                                <option value="2">Tuesday</option>--}}
{{--                                                                                <option value="3">Wednesday</option>--}}
{{--                                                                                <option value="4">Thursday</option>--}}
{{--                                                                                <option value="5">Friday</option>--}}
{{--                                                                                <option value="6">Saturday</option>--}}
{{--                                                                            </select>--}}
{{--                                                                        </td>--}}
{{--                                                                        <td>--}}
{{--                                                                            <div class="form-group"><input--}}
{{--                                                                                    id="notification_time" type="time"--}}
{{--                                                                                    class="form-control notificationInput"--}}
{{--                                                                                    name="notification_time[]"--}}
{{--                                                                                    value="{{ old('notification_time') }}">--}}
{{--                                                                            </div>--}}
{{--                                                                        </td>--}}
{{--                                                                        <td>--}}
{{--                                                                            <div class="form-group">--}}
{{--                                                                                <button type="button" name="add"--}}
{{--                                                                                        id="add"--}}
{{--                                                                                        class="button button--edit">Add--}}
{{--                                                                                    More--}}
{{--                                                                                </button>--}}
{{--                                                                            </div>--}}
{{--                                                                        </td>--}}
{{--                                                                    </tr>--}}
{{--                                                                </table>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="everyday_time">--}}
{{--                                                        <div class="row">--}}
{{--                                                            <div class="col-md-6">--}}
{{--                                                                <div class="form-group">--}}
{{--                                                                    <label>Notification time</label>--}}
{{--                                                                    <input type="time" class="form-control disabled"--}}
{{--                                                                           name="everyday_time"--}}
{{--                                                                           value="{{ old('everyday_time') }}">--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div
                                                            class="false-padding-bottom-form form-group{{ $errors->has('message') ? ' has-error' : '' }}">

                                                            <div class="sms-area">
                                                                <label for="message"
                                                                       class="control-label false-padding-bottom"><b>Message :</b></label>
                                                                <div class="alert alert-info">
                                                                    <ul>
                                                                        <li>
                                                                            <b>Hints :Please make sure you provide the following details:</b>
                                                                        </li>
                                                                        <li>
                                                                            <b>Class :</b>  class number [ Example : 4 ]
                                                                        </li>
                                                                        <li>
                                                                            <b>Section :</b>  class number [ Example : A ]
                                                                        </li>
                                                                        <li>
                                                                            <b>Time:</b> Class time [ Example : 1pm to 2pm ]
                                                                        </li>
                                                                        <li>
                                                                            <b>Shorten Url :</b> <b>{{ $tinyUrl ?? '' }}</b>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <textarea name="message" class="form-control sms-text-area" id="msg" onkeyup="limitCharacter()" onchange="limitCharacter()" cols="30" rows="8" ></textarea>

                                                                <span id="limit"></span>

                                                                <input type="hidden" name="sms_count" id="sms_count" class="sms_count" value="">
                                                                <br>
                                                                <span class="help-block invalid-msg d-none"><strong>Insert the url properly</strong></span>

                                                                @if ($errors->has('message'))
                                                                    <span
                                                                        class="help-block"><strong>{{ $errors->first('message') }}</strong></span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <button type="button" id="submit-btn"
                                                            class="button button--save float-right">
                                                        Sent
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                                <div class="card-body ">
                                    <div class="card-body-body pb-5 text-center">
                                        {{ __('text.No Related Data Found') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                </div>
            </div>
            @endsection


            @push('customjs')
                <script type="text/javascript">

                    $(document).ready(function() {
                        var class_number = $("#class_number").val();
                        getSections(class_number);
                    });

                    var url = "<?php echo $tinyUrl ?>";

                    $('#submit-btn').on('click', function (e) {
                        e.preventDefault();
                        var str = $('#msg').val();

                        if (str.indexOf(url) >= 0) {
                            $('#final-form').submit();
                            $('.invalid-msg').addClass('d-none');
                        } else {
                            $('.invalid-msg').removeClass('d-none');
                        }

                    });

                    var week_days = [];
                    var notification_times = [];

                    function getValues() {
                        getWeekValues();
                        getNotificaionTimes();

                        var result = week_days.map(function (el, i) {
                            return Object.assign({}, notification_times[i], el);
                        });

                        console.log(result);

                        $('#schedule').val(JSON.stringify(result));
                    }


                    function getWeekValues() {

                        var week_value = document.getElementsByName('week_day[]');

                        for (var i = 0; i < week_value.length; i++) {

                            var input = week_value[i];

                            week_days.push({week_key: input.value});

                        }
                    }


                    function getNotificaionTimes() {

                        var notification_time = document.getElementsByName('notification_time[]');

                        for (var i = 0; i < notification_time.length; i++) {

                            var input = notification_time[i];

                            notification_times.push({notification_key: input.value});

                        }
                    };

                    var i = 0;

                    $("#add").click(function () {

                        ++i;

                        $("#dynamicTable").append(`<tr><td><select id="week_day" class="form-control example select2" name="week_day[]" required>
                                                    <option value="">Select a weekday</option>
                                                    <option value="0">Sunday</option>
                                                    <option value="1">Montday</option>
                                                    <option value="2">Tuesday</option>
                                                    <option value="3">Wednesday</option>
                                                    <option value="4">Thursday</option>
                                                    <option value="5">Friday</option>
                                                    <option value="6">Saturday</option>
                                            </select>
                                        </td>
                                        <td><div class="form-group"><input type="time" class="form-control" name="notification_time[]" value="" required></div></td>
                                        <td><button type="button" class="button button--cancel remove-tr">Remove</button></td></tr>
                                        `);
                        $('.select2').select2().select2({width: '100%'});

                    });

                    $(document).on('click', '.remove-tr', function () {
                        $(this).parents('tr').remove();
                    });

                    $('.Is_repeat').on('click', function () {
                        if ($(this).prop("checked") == true) {
                            $('.for-repeatable').css('display', 'block');
                            $('.Week-check select').prop('required', true);
                            $('.everyday_time input').prop('disabled', true);
                        } else {
                            $('.for-repeatable').css('display', 'none');
                            $('.Week-check input').prop('required', false);
                        }
                    });


                    $('#is_everyday').on('click', function () {
                        if ($(this).prop("checked") == true) {
                            $('.Week-check').css('display', 'none');
                            $('.Week-check select').prop('required', false);
                            $('.Week-check input').prop('required', false);
                            $('.Week-check select').prop('disabled', true);
                            $('.Week-check input').prop('disabled', true);
                            $('.everyday_time').css('display', 'block');
                            $('.everyday_time input').prop('required', true);
                            $('.everyday_time input').prop('disabled', false);
                        } else {
                            $('.Week-check').css('display', 'block');
                            $('.Week-check select').prop('required', true);
                            $('.Week-check input').prop('required', true);
                            $('.Week-check select').prop('disabled', false);
                            $('.Week-check input').prop('disabled', false);
                            $('.everyday_time').css('display', 'none');
                            $('.everyday_time input').prop('required', false);
                            $('.everyday_time input').prop('disabled', true);
                        }
                    });

                    function limitCharacter() {
                        var english = /^[A-Za-z0-9-!$%^&*()_+|~=`{}\[\]:";'<>?,.\/#!|±@ \n]*$/;

                            $('#msg').attr('maxlength', 1000);

                            let msg = $('#msg').val();

                            if (!english.test(msg)) {
                                console.log('its not english');
                                let count = msg.length / 70;
                                if (msg.length > 70) {
                                    $('#limit').text(msg.length + '/' + Math.ceil(count) + ' ( 70 Characters for 1 Bangla sms )');
                                } else {
                                    $('#limit').text(msg.length + '/' + Math.ceil(count));
                                }
                                $('#sms_count').val(Math.ceil(count));
                            } else {
                                console.log('its english');
                                let count = msg.length / 160;
                                if (msg.length > 160) {
                                    $('#limit').text(msg.length + '/' + Math.ceil(count) + ' ( 160 Characters for 1 English sms )');
                                } else {
                                    $('#limit').text(msg.length + '/' + Math.ceil(count));
                                }
                                $('#sms_count').val(Math.ceil(count));
                            }
                    }

                    function getSections(item) {
                        let selectedClass = item;
                        let classes = {!! json_encode($classes->toArray()) !!};
                        let sections = [];
                        classes.forEach((cls) => {
                            if (cls.id == selectedClass) {
                                sections = cls.sections;
                            }
                        });

                        $('#section').empty();
                        sections.forEach((sec) => {
                            $('#section').append($("<option />").val(sec.id).text(sec.section_number));
                            $('#section_id').val(sec.id);
                        });
                    }
                </script>

    @endpush
