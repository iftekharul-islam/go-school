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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" id="main-container">
                <div class="breadcrumbs-area">
                    <h3>
                        Message Student
                    </h3>
                    <ul>
                        <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                                Back &nbsp;&nbsp;|</a>
                            <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                        </li>
                        <li>Message Student</li>
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
                <div class="card height-auto false-height">
                    <div class="card-body">
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
                                        <form action="{{url('teacher/message/students')}}" method="POST" enctype="multipart/form-data" id="msgForm" class="new-added-form">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="teacher_id" value="{{$teacher_id}}">
                                            <input type="hidden" name="section_id" value="{{$section_id}}">
                                            <div class="form-group">
                                                <label for="msg">Write Message: </label>
                                                <textarea name="msg" class="form-control" id="msg" cols="30" rows="10"></textarea>
                                                <label for="">Attach file here :</label>
                                                <br><input type="file" name="file_path">
                                            </div>
                                            <button type="submit" class="button button--save float-right">Message</button>
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
                                <div class="card mt-5 false-height">
                                    <div class="card-body">
                                        <div class="card-body-body mt-5 text-center">
                                            No Related Data Found.
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
