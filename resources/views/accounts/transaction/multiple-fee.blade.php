@extends('layouts.student-app')
@section('title', 'Multiple Fee Transaction')
@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area example-screen">
            <h3>Dashboard</h3>
            <ul>
                <li>
                    <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
                </li>
                <li>Multiple Fee Collection</li>
            </ul>
        </div>
        <form class="new-added-form fee-transaction" id="fee-transaction" action="{{ route('multiple.fee.store') }}" method="post">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="card height-auto false-height">
                        <div class="card-body">
                            <table class="table display table-borderless text-wrap table-sm ml-4">
                                <thead>
                                <tr>
                                    <th>Fee Name</th>
                                    <th>Due Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
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
                                @endphp
                                @foreach($student->section->class->feeMasters as $feeMaster)
                                    @if($feeMaster['format'] === 'recurrent')
                                        @foreach($months as $month)
                                            @php
                                                $total_paid = 0;
                                                $totalAmount = $totalAmount + $feeMaster->amount;
                                            @endphp
                                            <tr>
                                                @foreach($feeMaster->transactions as $transaction)
                                                    @foreach($transaction['transactionMonths'] as $tm)
                                                        @if($tm->fee_transaction_id === $transaction->id && $month === $tm->month)
                                                            @if($student->id === $transaction->student_id)
                                                                @php
                                                                    $total_paid = $total_paid + $transaction['amount'] + $transaction['discount'] - $transaction['fine']
                                                                @endphp
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                                @if($total_paid < $feeMaster->amount && $total_paid === 0)
                                                    <td class="text-capitalize">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" name="month[]" value="{{ $month }}" id="chktype" onclick="calculateTotal({{ $feeMaster->amount }}, $(this), {{ $feeMaster->id }})">
                                                            <label class="form-check-label"><span class="badge-success badge"><b>{{ $month }}</b></span> {{ $feeMaster->feeType->name }}</label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $month }} - {{ $feeMaster->due }}</td>
                                                    <td>{{ $feeMaster->amount }}</td>
                                                    <td>
                                                        @foreach($feeMaster->transactions as $transaction)
                                                            @if($month === $transaction['month'] && $student->id === $transaction->student_id)
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
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card height-auto false-height">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>Date</label>
                                    <input type="text" placeholder="" class="form-control" value="{{  \Carbon\Carbon::today()->toDateString() }}" name="month" disabled>
                                </div>

                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>Fine <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" placeholder="" class="form-control fineInput fine" name="fine" value="0" required>
                                </div>

                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>Discount <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" placeholder="" class="form-control discountInput discount" name="discountAmount" value="0" id="discountValue">
                                </div>

                                <div class="col-6-xxxl col-lg-6 col-6 form-group">
                                    <label>Amount <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" placeholder="" class="form-control" name="amount" value="{{ 0 }}" id="amount" style="pointer-events: none; touch-action: none;">
                                    <div class="error text-danger"></div>
                                </div>

                                <div class="col-6-xxxl col-lg-6 col-6 form-group mt-5">
                                    <label>Payment Method</label>
                                    <input class="ml-5" type="radio" name="mode" value="cash" checked> Cash
                                    <input class="" type="radio" name="mode" value="cheque"> Cheque
                                </div>
                                <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                    <label>Note</label>
                                    <textarea name="note" id="" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <input type="hidden" name="feeMasterId[]" value="" id="feeMasterId">
                            <button class="button button--save float-right mt-4" style="max-width: 400px !important;">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('customjs')
    <script>
        window.total = $("#amount").val();
        $(document).ready(function(){
            $(".fine").change(function(){
                let grandTotal = 0;
                let fine = $(".fine").val();
                if (fine != '') {
                    grandTotal = parseFloat(total) + parseFloat(fine);
                } else {
                    $(".fine").val(0)
                }
                let dis = $(".discount").val();
                grandTotal = grandTotal - dis;
                $("#amount").val(grandTotal);
            });

            $(".discount").change(function(){
                let grandTotal = 0;
                let fine = $(".fine").val();
                if (fine != '') {
                    grandTotal = parseFloat(total) + parseFloat(fine);
                } else {
                    $(".fine").val(0)
                }
                let dis = $(".discount").val();
                grandTotal = grandTotal - dis;
                $("#amount").val(grandTotal);
            });

        });
        window.i = 0;
        window.feeMasterId = [];
        function calculateTotal(e, t, id) {
            if (t.is(':checked')) {
                total = parseFloat($("#amount").val()) + parseFloat(e);
                feeMasterId.push(id);
            } else {
                total = parseFloat($("#amount").val()) - parseFloat(e);
                var idx = feeMasterId.indexOf(id);
                feeMasterId.splice(idx, 1);
            }
            $("#amount").val(total);
            $("#feeMasterId").val(feeMasterId);
        }

    </script>
@endpush