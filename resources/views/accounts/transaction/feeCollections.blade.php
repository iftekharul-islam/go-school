@extends('layouts.student-app')
@section('title', 'Fee Collection')
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
            <h3>Fee Collections</h3>
            <ul>
                <li>
                    <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
                </li>
                <li>Fee Collection</li>
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
                                    <th>Balance</th>
                                    <td colspan="3">{{ number_format($student->studentInfo['advance_amount'], 2) }}</td>
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
                        <h3 class="float-left mb-5 float-left">Fee Collection</h3>
                        <button class="btn-secondary btn float-right btn-lg" onclick="window.print()"> <i class="fa-print fa"></i> Print pdf</button>

                    </div>
                </div>
                @php
                    $totalFine = 0;
                    $totalDiscount = 0;
                    $totalAmount = 0;
                @endphp
                <div class="table-responsive">
                    <table class="table display table-bordered table-hover  text-wrap table-sm">
                        <thead>
                        <tr>
                            <th>Transaction No.</th>
                            <th>Fine</th>
                            <th>Discount</th>
                            <th>Amount</th>
                            <th>Mode</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!$fees->isEmpty())
                            @foreach($fees as $fee)
                                @php
                                    $totalFine += $fee->fine;
                                    $totalDiscount +=  $fee->discount;
                                    $totalAmount += $fee->amount;
                                @endphp
                                <tr>
                                    <td>{{ $fee->id }}</td>
                                    <td>{{ $fee->fine }}</td>
                                    <td>{{ $fee->discount }}</td>
                                    <td>{{ $fee->amount }}</td>
                                    <td>{{ $fee->mode }}</td>
                                    <td>{{ $fee->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <button title="Cancel Transaction" class="btn btn-secondary" onclick="feeTransaction({{ $fee->id }})"><i class="fas fa-history"></i></button>&nbsp;
                                        <a  title="View Transaction Details" class="btn btn-primary" href="{{ route('transaction.detail',['id' => $fee->id]) }}"><i class="fas fa-eye"></i></a>
                                        <form id="delete-form-{{ $fee->id }}" action="{{ url(auth()->user()->role.'/fee-transaction', $fee->id) }}" method="POST">
                                            {!! method_field('delete') !!}
                                            {!! csrf_field() !!}
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            <tr style="background-color: #eee">
                                <td>Total</td>
                                <td>{{ number_format($totalFine, 2) }}</td>
                                <td>{{ number_format($totalDiscount, 2) }}</td>
                                <td>{{ number_format(($totalAmount + $totalFine - $totalDiscount), 2) }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
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
                    <h4 class="float-left mr-5"><span><strong>Student Name :</strong> {{ $student->name }}</span></h4>
                    <h4 class="float-left mr-5"><span><strong>Student ID :</strong> {{ $student->student_code }}</span></h4>
                    <h4 class="ml-5"><span><strong>Class :</strong> Class{{ $student->section->class['class_number'] }} ({{ $student->section['section_number'] }})</span></h4>
                </div>
                <div class="table-responsive print-div">
                    <table class="table display text-wrap table-bordered">
                        <thead>
                            <tr>
                                <th>Transaction No.</th>
                                <th>Fine</th>
                                <th>Discount</th>
                                <th>Amount</th>
                                <th>Mode</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$fees->isEmpty())
                                @foreach($fees as $fee)
                                    <tr>
                                        <td>{{ $fee->id }}</td>
                                        <td>{{ $fee->fine }}</td>
                                        <td>{{ $fee->discount }}</td>
                                        <td>{{ $fee->amount }}</td>
                                        <td>{{ $fee->mode }}</td>
                                        <td>{{ $fee->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                                <tr style="background-color: #eee">
                                    <td>Total</td>
                                    <td>{{ number_format($totalFine, 2) }}</td>
                                    <td>{{ number_format($totalDiscount, 2) }}</td>
                                    <td>{{ number_format(($totalAmount + $totalFine - $totalDiscount), 2) }}</td>
                                    <td></td>
                                    <td></td>
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

@push('customjs')
    <script>
        function feeTransaction(id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Transaction!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        document.getElementById('delete-form-'+id).submit();
                        setTimeout(5000);
                        swal("Done! Your transaction has been cancelled!", {
                            icon: "success",
                        });
                    }
                });
        };
    </script>
@endpush
