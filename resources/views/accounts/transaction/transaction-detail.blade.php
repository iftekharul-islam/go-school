@extends('layouts.student-app')
@section('title', 'Transaction Details')
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
        <div class="breadcrumbs-area example-screen">
            <h3>Transaction Details</h3>
            <ul>
                <li>
                    <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
                </li>
                <li>Fee Collection</li>
                <li>Transaction Details</li>
            </ul>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="card height-auto mb-3 example-screen">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <img src="{{url($student->pic_path)}}" style="height: 130px;" alt="">
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <table class="table">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $student->name }}</td>
                                    <th>Class & Section</th>
                                    <td> Class {{ $student->section->class['class_number'] }} ({{ $student->section['section_number'] }})</td>
                                </tr>
                                @if($student['studentInfo'])
                                    <tr>
                                        <th>Father's Name</th>
                                        <td>{{ $student->studentInfo['father_name'] }}</td>
                                        <th>Phone</th>
                                        <td>{{ $student->studentInfo['father_phone_number'] }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Version</th>
                                    <td>@if($student->studentInfo){{ $student->studentInfo['version'] }}@endif </td>
                                    <th>Student Code</th>
                                    <td>{{ $student->student_code }}</td>
                                </tr>
                                <tr>
                                    <th>Transaction No.</th>
                                    <td colspan="3">{{ $fee_transaction->transaction_serial }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card height-auto false-height example-screen">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3 class="float-left mb-5 float-left">Items</h3>
{{--                        <button class="btn-secondary btn float-right btn-lg" onclick="window.print()"> <i class="fa-print fa"></i> Print pdf</button>--}}
                        <a href="?print=1" class="btn-secondary btn float-right btn-lg" target="_blank"> <i class="fa-print fa"></i> Print</a>
                    </div>
                </div>
                @php $totalAmount = 0; @endphp
                <div class="table-responsive">
                    <table class="table display table-bordered table-hover  text-wrap table-sm">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Fee Name</th>
                            <th class="text-right">Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!$transactionItems->isEmpty())
                            @foreach($transactionItems as $key => $item)
                                @php $totalAmount += $item->fee_amount; @endphp
                                <tr>
                                    <td>{{ $key + 1}}</td>
                                    <td>{{ $item['fee_type']['name'] }}</td>
                                    <td class="text-right">{{ number_format($item->fee_amount, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td>Fine</td>
                                <td class="text-right">{{ number_format($fee_transaction->fine, 2) }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Discount</td>
                                <td class="text-right">{{ number_format($fee_transaction->discount, 2) }}</td>
                            </tr>
                            <tr style="background-color: #eee">
                                <td></td>
                                <td><b>Total</b></td>
                                <td class="text-right"><b>{{ number_format(($totalAmount + $fee_transaction->fine - $fee_transaction->discount), 2) }}</b></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


{{--        Printing Page--}}

        <div class="card height-auto false-height example-print">
            <div class="card-body">
                <div class="report" style="overflow: hidden;">
                    <div class="school-property mb-5">
                        <h2 class="text-center mb-0">{{ $student->school->name }}</h2>
                        <h5 class="text-center">{{ $student->school->school_address }}</h5>
                        <h5 class="text-center"><strong>Date:</strong> {{ date('d-M-Y') }}</h5>
                    </div>
                    <h4><span><strong>Transaction No :</strong> {{ $fee_transaction->transaction_serial }}</h4>
                    <h4 class="float-left mr-5"><span><strong>Student Name :</strong> {{ $student->name }}</span></h4>
                    <h4 class="float-left mr-5"><span><strong>Student ID :</strong> {{ $student->student_code }}</span></h4>
                    <h4 class="ml-5"><span><strong>Class :</strong> Class{{ $student->section->class['class_number'] }} ({{ $student->section['section_number'] }})</span></h4>
                </div>
                <div class="table-responsive print-div">
                    <table class="table display text-wrap table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Fee Name</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!$transactionItems->isEmpty())

                            @foreach($transactionItems as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item['fee_type']['name'] }}</td>
                                    <td class="text-right">{{ number_format($item->fee_amount, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td>Fine</td>
                                <td class="text-right">{{ number_format($fee_transaction->fine, 2) }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Discount</td>
                                <td class="text-right">{{ number_format($fee_transaction->discount, 2) }}</td>
                            </tr>
                            <tr style="background-color: #eee">
                                <td></td>
                                <td><b>Total</b></td>
                                <td class="text-right"><b>{{ number_format($fee_transaction->amount, 2) }}</b></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="signature" style="margin: 100px 0 0 40px;">
                <hr style="width: 30%; margin-left: -10px; display: block;border-width: 1.4px; border-color: #000000">
                <p style="margin-left: 50px;">Signature of Accountant</p>
            </div>
        </div>
    </div>
@endsection