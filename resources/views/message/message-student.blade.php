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
                Message Student
            </h3>
            <ul>
                <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                        Back &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li>Message Student</li>
            </ul>
        </div>
        <div class="false-height">
                <div class="card mb-3">
                    <div class="card-body">
                        <form class="new-added-form" action="{{ url(auth()->user()->role.'/student-message') }}" method="get">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>Class</label>
                                    <select name="class" id="class_number" class="select2" onchange="getSections(this)">
                                        <option>Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">class - {{ $class->class_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>Section</label>
                                    <select class="form-control" id="section" name="section" ></select>
                                </div>
                                <div class="col-12 form-group mg-t-2 float-right">
                                    <button type="submit" class="button--save button float-right">Search</button>
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
                                <h4>Students of <b>Class:</b> {{$student->section->class->class_number}} <b>Section:</b> {{$student->section->section_number}}</h4>
                                @break
                            @endforeach
                            <h4>Select Students to send message</h4>
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
                                    </div>
                                    <div class="col-md-12">
                                        <form action="{{url('teacher/message/students')}}" method="POST" id="msgForm" class="new-added-form">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="teacher_id" value="{{Auth::user()->id}}">
                                            <input type="hidden" name="section_id" value="{{0}}">
                                            <div class="form-group">
                                                <label for="msg">Write Message: </label>
                                                <textarea name="msg" class="form-control" id="msg" cols="30" rows="10"></textarea>
                                            </div>
                                            <div class="checkbox">
                                                <input type="checkbox" id="sentsms" name="recipients[]" form="msgForm"
                                                       value="{{$student->id}}">
                                                <label for="sentsms">Sent SMS</label>
                                                <button type="submit" class="button button--save float-right">Message</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                                <script>
                                    $(function () {
                                        var r = $(':checkbox[name="recipients[]"]');
                                        $('#selectAll').on('change', function () {
                                            if ($(this).is(':checked')) {
                                                r.prop('checked', true);
                                            } else {
                                                r.prop('checked', false);
                                            }
                                        });
                                        ClassicEditor
                                            .create(document.querySelector('#msg'), {
                                                toolbar: ['bold', 'italic','Heading', 'Link', 'bulletedList', 'numberedList', 'blockQuote']
                                            })
                                            .catch(error => {
                                                console.error(error);
                                            });
                                    });

                                </script>
                            @else
                                <div class="card-body ">
                                    <div class="card-body-body pb-5 text-center">
                                        No Related Data Found.
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
