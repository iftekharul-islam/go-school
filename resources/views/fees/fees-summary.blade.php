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
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
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
                                    <th>Fee Amount</th>
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
                                            $t = $fee->transaction_items;
                                            $total = 0;
                                            $ff = 0;
                                        @endphp
                                        <tr>
                                            <td>{{ $fee->transaction_serial }}</td>
                                            <td>
                                                @foreach($t as $item)
                                                    @php
                                                        $total +=$item->fee_amount;
                                                    @endphp
                                                @endforeach
                                                {{ $total }}
                                            </td>
                                            <td>{{ $fee->fine }}</td>
                                            <td>{{ $fee->discount }}</td>
                                            <td>{{ $fee->amount }}</td>
                                            <td>{{ $fee->mode }}</td>
                                            <td>{{ $fee->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <a  title="View Transaction Details" class="btn btn-info" href="{{ url(auth()->user()->role.'/transaction-detail/'.$fee->id) }}"><i class="fas fa-clipboard-list"></i></a>
                                                <form id="delete-form-{{ $fee->id }}" action="{{ url(auth()->user()->role.'/fee-transaction', $fee->id) }}" method="POST">
                                                    {!! method_field('delete') !!}
                                                    {!! csrf_field() !!}
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr style="background-color: #eee">
                                        <td>Total</td>
                                        <td></td>
                                        <td>{{ number_format($totalFine, 2) }}</td>
                                        <td>{{ number_format($totalDiscount, 2) }}</td>
                                        <td>{{ number_format(($totalAmount), 2) }}</td>
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
            </div>
        </div>
    </div>
    <!-- All Subjects Area End Here -->
    {{--    </div>--}}

@endsection
