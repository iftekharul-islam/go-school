@extends('layouts.student-app')
@section('title', 'Admit card')
@section('content')
    <style>
        .example-print {
            display: none;
        }
        @media print {
            .example-screen {
                display: none;
            }

            .example-print {
                margin: 25mm 0 0 0;
                display: block;
            }
            .income-report {
                padding-bottom: 20px !important;
            }
        }
    </style>
    <div class="breadcrumbs-area example-screen">
        <h3>
            <i class="fas fa-file-invoice-dollar"></i>
           Admit card
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Admit card</li>
        </ul>
    </div>

    <div class="card height-auto">
        <div class="example-screen">
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="border">
                    <div class="page-header text-center">
                        <div class="fancy4">
                            <h2 class="mt-4">Admit card</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class=" table">
                                <table class="text-wrap table-borderless table ml-5 mt-5">
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap mr-4">Class</td>
                                        <td>
                                            <select name="class" id="inputClass" class="select2 "onchange="getSections(this)">
                                                <option>Select Class</option>
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}">class - {{ $class->class_number }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Sections</td>
                                        <td>
                                            <select class="select2" id="section" name="section">
                                                <option>Select section</option>
                                            </select>
                                        </td>
                                    </tr>
                                   

                                </table>
                            </div>
                        </div>
                     
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button  type="button" class="btn btn-secondary float-right mb-3 mt-2" id="get" ><i class="fa fa-print"></i> Print</button>
                    </div>
                </div>
            </div>
        </div>
      
    </div>

@endsection
@push('customjs')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#takeImg')
                        .attr('src', e.target.result)
                        .width(200)
                        .height(200);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#get").click(function () {
            $('#roll').html($('#inputRoll').val());
            $('#class').html($('#inputClass').val());
            $('#shift').html($('#inputShift').val());
            $('#name').html($('#inputName').val());
            $('#mother').html($('#inputMname').val());
            $('#father').html($('#inputFname').val());
            $('#exam').html($('#inputExam').val());
            $('#type').html($('#inputType').val());
            $('#duration').html($('#inputDuration').val());

            var newSrc = $('.img1 img').attr('src');

            $('.img2 img').attr("src", newSrc);
            window.print();
        });
        $( document ).ready(function() {
            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

            var optSimple1 = {
                format: 'mm-dd-yyyy',
                todayHighlight: true,
                orientation: 'bottom right',
                autoclose: true,
                container: '#sandbox'
            };
            $("#student").change(function(){
                var selectedStudent = $(this).children("option:selected").val();

            });
        });
        var users = [];

        function getSections(item) {
            let selectedClass = item.value;
            let classes = {!! json_encode($classes->toArray()) !!};
            let sections = [];
            let us = [];
            classes.forEach((cls) => {
                if (cls.id == selectedClass) {
                    sections = cls.sections;
                }
            });
            $('#section').empty();
            sections.forEach((sec) => {
                $('#section').append($("<option />").val(sec.id).text(sec.section_number));
                users = sec.users;
            });

            $('#student').empty();
            users.forEach((user)=> {
                $('#student').append($("<option />").val(user.id).text(user.id. .'user.name'.));
            });
        }

        $("#student").change(function(){
            var selectedStudent;
            selectedStudent = $(this).children("option:selected").val();
            console.log("selected student", selectedStudent);

            let userss;
            let user_info;
            users.forEach((user) => {
                if (selectedStudent == user.id) {
                    userss = user;
                    user_info = user.student_info;
                }
            });

            console.log(userss);
            if(user_info.roll_number !== null){
                $('#inputRoll').val(user_info.roll_number).attr("readOnly", true);
            }else{
                $('#inputRoll').val('').attr("readOnly",false);
            }

            if(user_info.shift !== null){
                $('#inputShift').val(user_info.shift).attr("readOnly", true);
            }else{
                $('#inputShift').val('').attr("readOnly",false);
            }

            $('#inputName').val(userss.name).attr("readOnly", true);

            if(user_info.mother_name !== null){
                $('#inputMname').val(user_info.mother_name).attr("readOnly", true);
            }else{
                $('#inputMname').val('').attr("readOnly",false);
            }

            if(user_info.father_name !== null){
                $('#inputFname').val(user_info.father_name).attr("readOnly", true);
            }else{
                $('#inputFname').val('').attr("readOnly",false);
            }

            if(user_info.guardian_name !== null){
                $('#inputFname').val(user_info.guardian_name).attr("readOnly", true);
            }else{
                $('#inputFname').val('').attr("readOnly",false);
            }
        });

    </script>
@endpush
