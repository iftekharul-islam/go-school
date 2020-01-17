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
        <div class="breadcrumbs-area example-screen">
            <h3>Fee Collection</h3>
            <ul>
                <li>
                    <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
                </li>
                <li>Fee Collection</li>
            </ul>
        </div>
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
                                @if($student->studentInfo)
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
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card height-auto false-height example-screen">
            <div class="card-body">
                <div class="heading-layout1">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="item-title">
                        <h3 class="float-left mb-5 float-left">Fee Collection</h3>
                        <button class="btn-secondary btn float-right btn-lg" onclick="window.print()"> <i class="fa-print fa"></i> Print pdf</button>
                        <a href="{{ url(auth()->user()->role.'/fee-collection/multiple-fee', $student->id) }}" class="btn btn-primary text-center btn-lg" style="margin-left: 60px;"><i class="fab fa-buffer"></i> <b>Collect Multiple Fees</b></a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table display table-borderless text-wrap table-sm">
                        <thead>
                        <tr>
                            <th>Class</th>
                            <th>Fee Name</th>
                            <th>Year</th>
                            <th>Due Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Mode</th>
                            <th>Date</th>
                            <th>Fine</th>
                            <th>Discount</th>
                            <th>Paid</th>
                            <th>Balance</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $months = ['January', 'February', 'March','April','May','June','July', 'August', 'September', 'October', 'November', 'December'];
                            $totalAmount = 0;
                            $totalFine = 0;
                            $totalDiscount = 0;
                            $totalDue = 0;
                            $totalPaid = 0;
                        @endphp
                        @foreach($student->section->class->feeMasters as $feeMaster)
                            @php
                                $total_paid = 0;
                                $totalAmount = $totalAmount + $feeMaster->amount;
                            @endphp
                            <tr>
                                <td>Class - {{ $feeMaster->myclass->class_number }}</td>
                                <td class="text-capitalize"> <span class="badge-success badge"></span> {{ $feeMaster->feeType['name'] }}</td>
                                <td>{{ now()->year }}</td>
                                <td>{{ $feeMaster->due }}</td>
                                <td>{{ $feeMaster->amount }}</td>
                                <td>
                                    @foreach($feeMaster->transactions as $transaction)
                                        @if($student->id === $transaction->student_id)
                                            @php
                                                $total_paid = $total_paid + $transaction['amount'] + $transaction['discount'] - $transaction['fine']
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if($total_paid >= $feeMaster->amount)
                                        <span class="badge-primary badge">Paid</span>
                                    @elseif($total_paid > 0 && $total_paid < $feeMaster->amount)
                                        <span class="badge-warning badge">Partial</span>
                                    @else
                                         <span class="badge-danger badge">Unpaid</span>
                                    @endif
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    @if( !($total_paid > $feeMaster->amount) && !($total_paid == $feeMaster->amount))
                                        <a data-id="{{ $feeMaster->id }}" data-amount="{{ $feeMaster->amount }}" data-month="" title="Add this item" class="open-AddBookDialog btn btn-primary" href="#feeCollect"><i class="fa-plus fa"></i></a>
                                    @endif
                                </td>
                            </tr>
                            @if(count($feeMaster->transactions) != 0)
                                @php
                                    $paid_amount = 0;
                                @endphp
                                @foreach($feeMaster->transactions as $transaction)
                                    @if($student->id === $transaction->student_id)
                                        @php
                                            $cunt = count($transaction->feeMasters);
                                            if ( $cunt == 1 ) {
                                                $paid_amount = $paid_amount + $transaction['amount'] - $transaction['fine'] + $transaction['discount'];
                                                $totalFine = $totalFine + $transaction['fine'];
                                                $totalDiscount = $totalDiscount + $transaction['discount'];
                                                $totalPaid = $totalPaid + $transaction['amount'];
                                            } else {
                                                $paid_amount = $paid_amount + $transaction['amount'] / $cunt + $transaction['discount'] / $cunt - $transaction['fine'] / $cunt;
                                                $totalFine = $totalFine + $transaction['fine'] / $cunt;
                                                $totalDiscount = $totalDiscount + $transaction['discount'] / $cunt;
                                                $totalPaid = $totalPaid + $transaction['amount'] / $cunt;
                                            }
                                        @endphp
                                        <tr>
                                            <td></td>
                                            <td class="text-capitalize"></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><img class="enter-icon" src="{{ asset('template/img/enter.png') }}" alt=""></td>
                                            <td>{{ $transaction['mode'] }}</td>
                                            <td> {{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y') }} </td>
                                            <td>{{number_format((float)($transaction['fine'] / $cunt), 2, '.', '')}}</td>
                                            <td>{{number_format((float)($transaction['discount'] / $cunt), 2, '.', '')}}</td>
                                            <td>
                                                {{number_format((float)($transaction['amount'] / $cunt), 2, '.', '')}}
                                            </td>
                                            <td>
                                                {{number_format((float)($feeMaster->amount - $paid_amount), 2, '.', '')}}
                                            </td>
                                            <td>
                                                <button class="btn btn-secondary" onclick="feeTransaction({{ $transaction->id }})"><i class="fas fa-history"></i></button>
                                                <form id="delete-form-{{ $transaction->id }}" action="{{ url(auth()->user()->role.'/fee-transaction', $transaction->id) }}" method="POST">
                                                    {!! method_field('delete') !!}
                                                    {!! csrf_field() !!}
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        <tr style="background-color: #F0F1F3;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="tex text-left">Grand Total</td>
                            <td>{{number_format((float)($totalAmount), 2, '.', '')}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{number_format((float)($totalFine), 2, '.', '')}}</td>
                            <td>{{number_format((float)($totalDiscount), 2, '.', '')}}</td>
                            <td>{{number_format((float)($totalPaid), 2, '.', '')}}</td>
                            <td>{{number_format((float)((int)($totalAmount - $totalDiscount + $totalFine - $totalPaid)), 2, '.', '')}}</td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="modal fade" id="feeCollect" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Fee Collection</h4>
                                    <button type="button" class="btn-secondary btn" data-dismiss="modal" aria-hidden="true"><i class="fas fa-window-close"></i></button>
                                </div>
                                <div class="modal-body p-5">
                                    <form class="new-added-form fee-transaction" id="fee-transaction" action="{{ url(auth()->user()->role.'/fee-transaction') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="student_id" value="{{ $student->id }}">
                                        <input type="hidden" name="feeMasterId" value="" id="feeMasterId">
                                        <input type="hidden" name="month" id="month">
                                        <input type="hidden" name="totalAmount" id="totalAmount">
                                        <div class="row">
                                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                                <label>Date</label>
                                                <input type="text" placeholder="" class="form-control" value="{{  \Carbon\Carbon::today()->toDateString() }}" name="month" disabled>
                                            </div>
                                            <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                                <label>Discount Group</label>
                                                <select class="select2" id="discount" name="discount" onchange="getDiscount(this)">
                                                    <option value="">Please Select</option>
                                                    @foreach($discounts as $discount)
                                                        <option value="{{ $discount->id }}">{{ $discount->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                                <label>Discount <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" placeholder="" class="form-control discountInput discount" name="discountAmount" value="0" id="discountValue" style="pointer-events: none; touch-action: none;">
                                            </div>
                                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                                <label>Fine <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" placeholder="" class="form-control fineInput fine" name="fine" value="0" required>
                                            </div>
                                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                                <label>Payable Amount <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" placeholder="" class="form-control" name="amount" value="" id="amount" required>
                                                <div class="error text-danger"></div>
                                            </div>
                                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                                <label>Payment Method</label>
                                                <input class="ml-5" type="radio" name="mode" value="cash" checked> Cash
                                                <input class="" type="radio" name="mode" value="cheque"> Cheque
                                            </div>
                                            
                                            <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                                <label>Note</label>
                                                <textarea name="note" id="" cols="30" rows="10" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-12 form-group mg-t-8">
                                        <button onclick="formSubmit()" class="button button--save float-right" style="margin-right: -15px !important;">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                            <th>Fee Name</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Paid</th>
                            <th>Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $months = ['January', 'February', 'March','April','May','June','July','August','September', 'October', 'November', 'December'];
                            $totalAmount = 0;
                            $totalFine = 0;
                            $totalDiscount = 0;
                            $totalDue = 0;
                            $totalPaid = 0;
                            $paid_amount = 0;
                            $paid_amount1 = 0;
                        @endphp
                        @foreach($student->section->class->feeMasters as $feeMaster)
                            @php
                                $total_paid = 0;
                                $totalAmount = $totalAmount + $feeMaster->amount;
                            @endphp
                            <tr>
                                <td class="text-capitalize"> <span class="badge-success badge month"></span> {{ $feeMaster->feeType['name'] }}</td>
                                <td>{{ $feeMaster->amount }}</td>
                                <td>
                                    @foreach($feeMaster->transactions as $transaction)
                                        @if($student->id === $transaction->student_id)
                                            @php
                                                $total_paid = $total_paid + $transaction['amount'] + $transaction['discount'] - $transaction['fine']
                                            @endphp
                                        @endif
                                    @endforeach
                                    @if($total_paid >= $feeMaster->amount)
                                        <span class="badge-primary badge paid">Paid</span>
                                    @elseif($total_paid > 0 && $total_paid < $feeMaster->amount)
                                        <span class="badge-warning badge partial">Partial</span>
                                    @else
                                        <span class="badge-danger badge unpaid">Unpaid</span>
                                    @endif
                                </td>
                                <td>
                                    @if(count($feeMaster->transactions) != 0)
                                        @php
                                            $paid_amount = 0;
                                        @endphp
                                        @foreach($feeMaster->transactions as $transaction)
                                            @if($student->id === $transaction->student_id)
                                                @php
                                                    $cunt = count($transaction->feeMasters);
                                                    if ( $cunt == 1 ) {
                                                        $paid_amount = $paid_amount + $transaction['amount'] - $transaction['fine'] + $transaction['discount'];
                                                        $totalFine = $totalFine + $transaction['fine'];
                                                        $totalDiscount = $totalDiscount + $transaction['discount'];
                                                        $totalPaid = $totalPaid + $transaction['amount'];
                                                    } else {
                                                        $paid_amount = $paid_amount + ($transaction['amount']/$cunt) + ($transaction['discount']/$cunt) - ($transaction['fine']/$cunt);
                                                        $totalFine = $totalFine + $transaction['fine'] / $cunt;
                                                        $totalDiscount = $totalDiscount + $transaction['discount'] / $cunt;
                                                        $totalPaid = $totalPaid + $transaction['amount'] / $cunt;
                                                    }
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endif
                                    {{number_format((float)($paid_amount), 2, '.', '')}}
                                </td>
                                <td>{{number_format((float)($feeMaster->amount - $paid_amount), 2, '.', '')}}</td>
                            </tr>
                        @endforeach
                        <tr class="grand-total">
                            <td class="tex text-left"><b>Grand Total</b></td>
                            <td><b>{{number_format((float)($totalAmount), 2, '.', '')}}</b></td>
                            <td></td>
                            <td><b>{{number_format((float)($totalPaid), 2, '.', '')}}</b></td>
                            <td><b> {{number_format((float)((int)($totalAmount - $totalDiscount + $totalFine - $totalPaid)), 2, '.', '')}}</b></td>
                        </tr>
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
                        swal("Done! Your Selected file has been deleted!", {
                            icon: "success",
                        });
                    }
                });
        };

        function formSubmit() {
            let send_amount = $("#amount").val();
            let send_dis = $(".discount").val();
            let send_fine = $(".fine").val();
            let demo = parseFloat(send_amount) + parseFloat(send_dis) - parseFloat(send_fine);

            if (demo > amounts) {
                $(".error").append("<p class='text-danger'>Paid amount can not be greater than Payable amount</p>")
            }
            else {
                document.getElementById('fee-transaction').submit();
            }
        };

        $(document).ready(function() {
            $(".fine").change(function() {
                let grandTotal = 0;
                let fine = $(".fine").val();
                if (fine != '') {
                    grandTotal = parseFloat(amounts) + parseFloat(fine);
                } else {
                    $(".fine").val(0)
                }
                let dis = $(".discount").val();
                grandTotal = grandTotal - dis;
                $("#amount").val(grandTotal);
            });

            $('#feeCollect').on('hidden.bs.modal', function (e) {
                $('.discount').prop('selectedIndex',0);
                $("form").trigger("reset");
            });
        });

        $(document).on("click", ".open-AddBookDialog", function (e) {
            e.preventDefault();
            let _self = $(this);
            let feeMasterId = _self.data('id');
            let amount = _self.data('amount');
            window.amounts = _self.data('amount');
            let month = _self.data('month');
            $("#feeMasterId").val(feeMasterId);
            $("#amount").val(amount);
            $("#totalAmount").val(amount);
            $("#month").val(month);
            $(_self.attr('href')).modal('show');
        });

        function getDiscount(item) {
            let selectedDiscount = item.value;
            let discounts = {!! json_encode($discounts->toArray()) !!};
            let value;
            discounts.forEach((cls) => {
                if (cls.id == selectedDiscount) {
                    value = cls.amount;
                }
            });
            $('#discountValue').val(value);
            let grandTotal = 0;
            let fine = $(".fine").val();
            if (fine != '') {
                grandTotal = parseFloat(amounts) + parseFloat(fine);
            } else {
                $(".fine").val(0)
            }
            let dis = $(".discount").val();
            grandTotal = grandTotal - dis;
            $("#amount").val(grandTotal);
        }
    </script>
@endpush
