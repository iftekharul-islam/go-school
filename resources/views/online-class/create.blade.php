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
                                <select name="class" id="class_number" class="select2"
                                        onchange="getSections(this.value)">
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
                            {{--                            <div class="col-12 form-group mg-t-2">--}}
                            {{--                                <label class="form-check-label" for="url">Online class URL</label>--}}
                            {{--                                <input type="url" name="url"--}}
                            {{--                                       class="form-control" placeholder="Enter url ..." value="{{ $url ?? '' }}">--}}
                            {{--                            </div>--}}
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
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-primary float-right"
                                                    data-toggle="modal" data-target="#exampleModal">
                                                Generate online class url
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="url">Online class url</label>
                                                                <input type="text" id="url" class="form-control"
                                                                       name="url" placeholder="Enter url ...">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                            <button id="url-submit" type="button"
                                                                    class="btn btn-primary">Generate
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <form id="final-form" action="{{ route('class.schedule.store') }}"
                                                  method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="sec_id" value="{{ $section_id }}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div
                                                            class="false-padding-bottom-form form-group{{ $errors->has('message') ? ' has-error' : '' }}">

                                                            <div class="sms-area">
                                                                <label for="message"
                                                                       class="control-label false-padding-bottom"><b>Message
                                                                        :</b></label>
                                                                <div class="alert alert-info">
                                                                    <ul>
                                                                        <li>
                                                                            <b>Hints :Please make sure you provide the
                                                                                following details:</b>
                                                                        </li>
                                                                        <li>
                                                                            <b>Class :</b> class number [ Example : 4 ]
                                                                        </li>
                                                                        <li>
                                                                            <b>Section :</b> class number [ Example : A
                                                                            ]
                                                                        </li>
                                                                        <li>
                                                                            <b>Time:</b> Class time [ Example : 1pm to
                                                                            2pm ]
                                                                        </li>
                                                                        <li>
                                                                             <b>Shorten Url : </b> <b class="url-assign"></b>
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <textarea name="message"
                                                                          class="form-control sms-text-area" id="msg"
                                                                          onkeyup="limitCharacter()" cols="30"
                                                                          rows="8"></textarea>

                                                                <span id="limit"></span>

                                                                <input type="hidden" name="sms_count" id="sms_count"
                                                                       class="sms_count" value="">
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

                    var url = '';

                    $('#url-submit').on('click', function () {

                        var tiny_url = $('#url').val();

                        console.log(encodeURIComponent(tiny_url));

                        $.ajax({
                            url: '{{ url('generate-tiny-url') }}',
                            method: "post",
                            data: {_token: '{{ csrf_token() }}', tiny_url: encodeURIComponent(tiny_url)},

                            success: function (response) {
                                console.log(response.url);
                                url = decodeURIComponent(response.url);
                                console.log(url);
                                $('.sms-area div ul li .url-assign').html(url);
                                $('#exampleModal').modal('toggle');
                            },
                            error: function (response) {
                                console.log(response);
                            }
                        });

                    });

                    $(document).ready(function () {
                        var class_number = $("#class_number").val();
                        getSections(class_number);
                    });


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
