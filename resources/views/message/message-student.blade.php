@extends('layouts.student-app')

@section('title', 'Course Students')

@section('content')
    {{--    <script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>--}}
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <style>
        .ck-editor__editable{
            min-height: 200px;
        }
    </style>

    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>
                {{ __('text.Message Student') }}
            </h3>
            <ul>
                <li>
                    <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                        {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
                </li>
                <li>{{ __('text.Message Student') }}</li>
            </ul>
        </div>
        <div class="false-height">
                <div class="card mb-3">
                    <div class="card-body">
                        <form class="new-added-form" action="{{ url(auth()->user()->role.'/student-message') }}" method="get">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>{{ __('text.Class') }}</label>
                                    <select name="class" id="class_number" class="select2" onchange="getSections(this)">
                                        <option>Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">class - {{ $class->class_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>{{ __('text.Section') }}</label>
                                    <select class="select2" id="section" name="section" ></select>
                                </div>
                                <div class="col-12 form-group mg-t-2 float-right">
                                    <button type="submit" class="button--save button float-right">{{ __('text.Search') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

               <div class="card height-auto">
                    <div class="card-body">
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
                        @if(count($students) > 0)
                            @foreach ($students as $student)
                                <h4>Students of <b>Class:</b> {{$student->section['class']['class_number']}} <b>Section:</b> {{$student->section['section_number']}}</h4>
                                @break
                            @endforeach
                        @endif
                        <div class="panel panel-default">
                            @if(count($students) > 0)
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div class="responsive">
                                            <table class="table table-data-div table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>
                                                        <div class="checkbox">
                                                            <label style="font-weight:bold;">
                                                                <input type="checkbox" id="selectAll"> All
                                                            </label>
                                                        </div>
                                                    </th>
                                                    <th>Student Code</th>
                                                    <th>Student Name</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($students as $student)
                                                    <tr>
                                                        <td>
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" name="recipients[]" form="msgForm"
                                                                           value="{{$student->id}}">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>{{$student->student_code}}</td>
                                                        <td><a href="{{url('user/'.$student->student_code)}}" class="text-teal">{{$student->name}}</a></td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        {{ $students->links() }}
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{url('teacher/message/students')}}" method="POST" id="msgForm" enctype="multipart/form-data" class="new-added-form">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="teacher_id" value="{{Auth::user()->id}}">
                                            <input type="hidden" name="section_id" value="{{0}}">
                                            <div class="mt-3 mb-3">
                                                <label for="msg">{{ __('text.write_message') }}: </label>
                                                <textarea name="msg" class="form-control" id="msg" onkeyup="limitCharacter()" cols="30" rows="8" style="font-size:1.5rem"></textarea>
                                                <span id="limit"></span>
                                                <input type="text" name="sms_count" id="sms_count" class="sms_count d-none" value="">
                                                <br>
                                                <label for="">{{ __('text.add_attachment') }} :</label>
                                                <br><input type="file" name="file_path">
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" onchange="limitCharacter()" id="sent-sms" name="sent_sms"  form="msgForm">
                                                <label style="font-weight:bold; margin-left:10px">
                                                    Also Send as SMS
                                                </label>
                                                <button type="submit" class="button button--save float-right">{{ __('text.Submit') }}</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="card-body ">
                                    <div class="card-body-body pb-5 text-center">
                                        {{ __('text.No_related_data_notification') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
               </div>

        </div>
    </div>


@push('customjs')
    <script type="text/javascript">
        $(function () {
            var r = $(':checkbox[name="recipients[]"]');
            $('#selectAll').on('change', function () {
                if ($(this).is(':checked')) {
                    r.prop('checked', true);
                } else {
                    r.prop('checked', false);
                }
            });
        });

        function limitCharacter(){
            var english = /^[A-Za-z0-9-!$%^&*()_+|~=`{}\[\]:";'<>?,.\/#!|??@ \n]*$/;
            if ($('#sent-sms'). prop("checked") == true) {
                $('#msg').attr('maxlength', 1000);
                let msg = $('#msg').val();
                if (!english.test(msg))
                {
                    console.log('its not english');
                    let count = msg.length / 70 ;
                    if (msg.length > 70){
                        $('#limit').text(msg.length + '/' +Math.ceil(count)+ ' ( 70 Characters for 1 Bangla sms )');
                    } else {
                        $('#limit').text(msg.length + '/' +Math.ceil(count));
                    }
                    $('#sms_count').val(Math.ceil(count));
                }
                else
                {
                    console.log('its english');
                    let count = msg.length / 160 ;
                    if (msg.length > 160){
                        $('#limit').text(msg.length + '/' +Math.ceil(count)+ ' ( 160 Characters for 1 English sms )');
                    } else {
                        $('#limit').text(msg.length + '/' +Math.ceil(count));
                    }
                    $('#sms_count').val(Math.ceil(count));
                }
            } else {
                $('#limit').text('');
                $('#msg').removeAttr('maxlength');
            }
        }

        function getSections(item) {
            let selectedClass = item.value;
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
            });
        }
    </script>

@endpush

@endsection
