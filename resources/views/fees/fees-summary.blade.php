@extends('layouts.student-app')

@section('title', 'Fees Summary')

@section('content')

    {{--    <div class="dashboard-content-one">--}}
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>
            </a>Fees Summary
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Fees Summary</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- All Subjects Area Start Here -->
    <div class="row">
        <div class="col-12-xxxl col-12">
            <div class="card height-auto false-height">
                <div class="card-body">
                    <div class="card-body-body mb-5 text-center">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Payment Summary</h3>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered ">
                                <thead>
                                <tr>
                                    <th colspan="2">Fee Details</th>
                                    <th colspan="5">Payment Condition</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <th>Fee Name</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Paid Date</th>
                                    <th>Last Date</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                </tr>
                                @php
                                    $months = ['January', 'February', 'March','April','May','June','July','August','September', 'October', 'November', 'December'];
                                    $totalAmount = 0;
                                    $totalFine = 0;
                                    $totalDiscount = 0;
                                    $totalDue = 0;
                                    $totalPaid = 0;
                                @endphp
                                @isset($student->section->class)
                                    @foreach($student->section->class->feeMasters as $feeMaster)
                                        @php
                                            $total_paid = 0;
                                            $totalAmount = $totalAmount + $feeMaster->amount;
                                        @endphp
                                        <tr>
                                            <td class="text-capitalize"><span
                                                    class="badge-success badge month"></span> {{ $feeMaster->feeType['name'] }}
                                            </td>
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
                                                    @foreach($feeMaster->transactions as $transaction)
                                                        @if($student->id === $transaction->student_id)
                                                            {{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y') }}
                                                        @endif
                                                    @endforeach
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                {{ ($feeMaster->due) }}
                                            </td>
                                            <td>
                                                @php
                                                    $paid_amount = 0;
                                                    if(count($feeMaster->transactions) != 0)
                                                       foreach($feeMaster->transactions as $transaction) {
                                                        $count = count($transaction->feeMasters);
                                                        if($student->id === $transaction->student_id)
                                                           if ( $count == 1 ) {
                                                               $paid_amount = $paid_amount + $transaction['amount'] - $transaction['fine'] + $transaction['discount'];
                                                               $totalFine = $totalFine + $transaction['fine'];
                                                               $totalDiscount = $totalDiscount + $transaction['discount'];
                                                               $totalPaid = $totalPaid + $transaction['amount'];
                                                           } else {
                                                               $paid_amount = $paid_amount + ($transaction['amount']/$count) + ($transaction['discount']/$count) - ($transaction['fine']/$count);
                                                               $totalFine = $totalFine + $transaction['fine'] / $count;
                                                               $totalDiscount = $totalDiscount + $transaction['discount'] / $count;
                                                               $totalPaid = $totalPaid + $transaction['amount'] / $count;
                                                           }
                                                       }
                                                @endphp
                                                {{number_format((float)($paid_amount), 2, '.', '')}}
                                            </td>
                                            <td>{{number_format((float)($feeMaster->amount - $paid_amount), 2, '.', '')}}</td>
                                        </tr>
                                    @endforeach
                                @endisset
                                <tr class="grand-total">
                                    <td class="tex text-left"><b>Grand Total</b></td>
                                    <td><b>{{number_format((float)($totalAmount), 2, '.', '')}}</b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><b>{{number_format((float)($totalPaid), 2, '.', '')}}</b></td>
                                    <td>
                                        <b> {{number_format((float)((int)($totalAmount - $totalDiscount + $totalFine - $totalPaid)), 2, '.', '')}}</b>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- All Subjects Area End Here -->
    {{--    </div>--}}

@endsection
