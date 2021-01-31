@extends('layouts.student-app')

@section('title', 'Fees Summary')

@section('content')

    {{--    <div class="dashboard-content-one">--}}
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.fees_summary') }}
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url( current_user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>{{ __('text.fees_summary') }}</li>
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
                                <h3>{{ __('text.payment_summary') }}</h3>
                            </div>
                        </div>
                        <div class="table-responsive">
                            @component('components.fee_summary', [  'student' => $student,
                                                                    'discounts' => $discounts,
                                                                    'totalAmount' => $totalAmount,
                                                                    'totalFine' => $totalFine,
                                                                    'totalDiscount' => $totalDiscount,
                                                                    'totalFeePaid' => $totalFeePaid,
                                                                    'totalPaid' => $totalPaid,
                                                                    'paidAmount' => $paidAmount,
                                                                ]))
                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- All Subjects Area End Here -->

@endsection
