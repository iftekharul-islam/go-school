@extends('layouts.student-app')
@section('title', 'Fee Transaction')
@section('content')
    <style type="text/css">
        .example-print {
            display: none;
        }
        @media print {
            .example-screen {
                display: none;
            }
            .example-print {
                margin: 10mm 0 0 0;
                display: block;
            }
            .report {
                margin-bottom: 20px;
            }
            table tbody .grand-total td {
                background-color: #DCDCDC !important;
            }
            tbody td .month {
                background-color: #42A746 !important;
            }
            tbody td .month b {
                color: white !important;
            }
            tbody td .paid {
                color: white !important;
                background-color: #287C71 !important;
            }
            tbody td .partial {
                background-color: #FEC23E !important;
            }
            tbody td .unpaid {
                color: white !important;
                background-color: #DC3C45 !important;
            }
        }
    </style>
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Dashboard</h3>
            <ul>
                <li>
                    <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
                </li>
                <li>Fee Transaction</li>
            </ul>
        </div>
        <div class="false-height">
            <div class="card mb-3">
                <div class="card-body">
                    <form class="new-added-form" action="{{ url(auth()->user()->role.'/fee-collection/section/student') }}" method="get">
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
            @if(count($students) > 0)
                <div class="card height-auto">
                    <div class="card-body text-center">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>All Students</h3>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($students as $student)
                                    <tr>
                                        <td>{{ $loop->index }}</td>
                                        <td>{{ $student->section->class->class_number }}</td>
                                        <td>{{ $student->section->section_number }}</td>
                                        <td>{{ $student->student_code }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td class="text-capitalize">{{ $student->gender }}</td>
                                        <td>
                                            <a class="button--save button" href="{{ url(auth()->user()->role.'/fee-collection/get-fee',$student->id) }}">Collect</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            @if(count($students)>0)
                <div class="card mt-5">
                    <div class="card-body">
                        <div class="card-body-body mb-5 text-center">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>Students Payment Summary</h3>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered ">
                                    <thead>
                                    <tr>
                                        <th colspan="2">Students info</th>
                                        <th colspan="3">Payment Condition</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                        <td>Name</td>
                                        <td>code</td>
                                        <td>Total Amount</td>
                                        <td>Partial Paid</td>
                                        <td>Due</td>

                                        </tr>

                                        @php
                                            $months = ['January', 'February', 'March','April','May','June','July','August','September', 'October', 'November', 'December'];
                                            $totalAmount = 0;
                                            $totalFine = 0;
                                            $totalDiscount = 0;
                                            $totalDue = 0;
                                            $total_paid = 0;
                                            $paid_amount = 0;
                                            $paid_amount1 = 0;
                                            $test = '';
                                        @endphp

                                        @foreach($studentWithFees as $student)
                                            <tr>
                                                <td class="text-left">{{ $student->name  }}</td>
                                                <td class="text-left">{{ $student->student_code  }}</td>
                                                <td>{{ $student->section->class->feeMasters->sum('amount')  }}</td>

                                                @php $totalPaid = 0; $total_amount = 0; @endphp
                                                @foreach($student->section->class->feeMasters as $feeMaster)

                                                    @foreach($feeMaster->transactions as $transaction)
                                                        @if($student->id === $transaction->student_id)
                                                            @php
                                                                $total_amount = (float)$totalPaid + (float)$transaction['amount']+$transaction['discount'];
                                                                $totalPaid = $transaction['discount'];
                                                            @endphp
                                                        @endif
                                                    @endforeach

                                                @endforeach

                                                <td>
                                                    {{ $total_amount}}
                                                </td>
                                                <td>
                                                    {{ $student->section->class->feeMasters->sum('amount') - $totalPaid }}
                                                </td>

                                            </tr>
                                        @endforeach
                                     </tbody>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card mt-5 ">
                    <div class="card-body">
                        <div class="card-body-body mt-5 text-center">
                            No Related Data Found.
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

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
