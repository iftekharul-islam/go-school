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
                            <div class=" table-responsive">
                                <table class="text-wrap table-borderless table offset-2 mt-5">
                                    <tr class="">
                                        <td class="font-medium text-dark-medium text-nowrap" width="200">Roll number</td>
                                        <td><input type="text" id="inputRoll"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Class & Section</td>
                                        <td><input type="text" id="inputClass"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Shift</td>
                                        <td><input type="text" id="inputShift"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Student name</td>
                                        <td><input type="text" id="inputName"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Mother's name</td>
                                        <td><input type="text" id="inputMname"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Father's name</td>
                                        <td><input type="text" id="inputFname"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Exam Date</td>
                                        <td><input type="text" id="inputExam"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Exam type</td>
                                        <td><input type="text" id="inputType"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-medium text-dark-medium text-nowrap">Exam Duration</td>
                                        <td><input type="text" id="inputDuration"></td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <div class="col-md-4 img1 mt-5">
                            <img id="takeImg" src="#" alt="Select image" />
                            <input type='file' onchange="readURL(this);" />
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
        <div class="comtainer example-print">
            <div class="card-body">
                <div class="page-header text-center">
                        <div class="fancy4">
                            @if(!empty($school->school->logo))
                                <div class="school-logo">
                                    <img class="logo topbar-logo-mg float-left" src="{{ asset($school->logo) }}">
                                </div>
                            @else
                                <div class="header-logo">
                                    <img class="" src="{{ asset('/logos/header-logo.png') }}" alt="logo">
                                </div>
                            @endif
                            <h2 class="mb-0">{{ $school->school['name'] ? $school->school['name'] : 'Sample School admit card'}}</h2>
                            <small>{{ $school->school['school_address'] ? $school->school['school_address'] : '' }}</small>
                            <h2 class="mt-5 ">Admit card</h2>
                        </div>
                    </div>
                    <div class="">
                        <div class="col-md-12">
                            <div class="row border">
                                <div class="col-md-8">
                                    <div class=" table-responsive">
                                        <table class="text-wrap table-borderless table offset-2 mt-5">
                                            <tr class="">
                                                <td class="font-medium text-dark-medium text-nowrap" width="200">Roll number</td>
                                                <td><label for="" id="roll"></label></td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium text-nowrap">Class & Section</td>
                                                <td><label for="" id="class"></label></td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium text-nowrap">Shift</td>
                                                <td><label for="" id="shift"></label></td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium text-nowrap">Student name</td>
                                                <td><label for="" id="name"></label></td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium text-nowrap">Mother's name</td>
                                                <td><label for="" id="mother"></label></td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium text-nowrap">Father's name</td>
                                                <td><label for="" id="father"></label></td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium text-nowrap">Exam Date</td>
                                                <td><label for="" id="exam"></label></td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium text-nowrap">Exam type</td>
                                                <td><label for="" id="type"></label></td>
                                            </tr>
                                            <tr>
                                                <td class="font-medium text-dark-medium text-nowrap">Exam Duration</td>
                                                <td><label for="" id="duration"></label></td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-4 img2 mt-5">
                                    <img src="{{asset('template/img/user-default.png')}}"
                                         class="img-thumbnail" width="80%">
                                </div>
                                <div class="col-md-4 text-center float-right offset-8">
                                    <hr><strong>Signature of Principal</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="border mt-5">
                    <h4> General Instruction: </h4>
                    <ol class="ml-5" >
                        <li>Each candidate must bring printed copy of this admit card into the exam hall.</li>
                        <li>Candidate should be present in the concerned center in 30(thirty) minute before the exam starts.</li>
                        <li>Carring any kind of electronic device like the mobile phone is strongly prohibited.</li>
                    </ol>
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
        });
    </script>
@endpush
