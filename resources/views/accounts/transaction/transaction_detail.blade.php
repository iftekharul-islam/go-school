@extends('layouts.student-app')
@section('title', 'Transaction Details')
@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area example-screen">
            <h3>{{ __('text.transaction_details') }}</h3>
            <ul>
                <li>
                    <a href="{{ URL::previous() }}">{{ __('text.Back') }}</a> | <a
                        href="{{ route(current_user()->role . '.home') }}">{{ __('text.Home') }}</a>
                </li>
                <li>
                    <a href="{{ route('student.fee.collections',['id' => $student->id]) }}">{{ __('text.Fee Collection') }}</a>
                </li>
                <li>{{ __('text.transaction_details') }}</li>
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
                        <img src="{{url($student->pic_path)}}" class="img-min-height" alt="">
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <table class="table">
                                <tr>
                                    <th>{{ __('text.Name') }}</th>
                                    <td><a class="text-teal"
                                           href="{{url('user/'.$student->student_code)}}">{{$student->name}}</a></td>
                                </tr>
                                <tr>
                                    <th>{{ __('text.class_section') }}</th>
                                    <td> Class {{ $student->section->class['class_number'] }}
                                        ({{ $student->section['section_number'] }})
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('text.balance') }}</th>
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
                        <h3 class="float-left mb-5 float-left">{{ __('text.fees_summary') }}</h3>
                        <a href="?print=1" class="btn-secondary btn float-right btn-lg" target="_blank"> <i
                                class="fa-print fa"></i> Print</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table display table-bordered table-hover  text-wrap table-sm">
                        <thead>
                        <tr>
                            <th>{{ __('text.Name') }}</th>
                            <th class="text-right">{{ __('text.amount') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($transaction))
                            @foreach($transaction->transaction_items as $key => $item)
                                <tr>
                                    <td>{{ $item['fee_type']['name'] }} {{ $item['note'] ?? '' }}</td>
                                    <td class="text-right">{{ number_format($item->fee_amount, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>{{ __('text.fine') }}</td>
                                <td class="text-right">{{ number_format($transaction->fine, 2) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('text.discounts') }}</td>
                                <td class="text-right">{{ number_format($transaction->discount, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-right"><b>{{ __('text.grand_total') }}</b></td>
                                <td class="text-right">
                                    <b>{{ number_format(($total_amount + $transaction->fine - $transaction->discount), 2) }}</b>
                                </td>
                            </tr>
                            @if(!empty($partial))
                                <tr>
                                    <td class="text-right"><b>{{ __('text.partial_payment') }}</b></td>
                                    <td class="text-right">
                                        <b>{{ number_format(( $grand_total - ($transaction->amount + $transaction->deducted_advance_amount) ), 2) }}</b>
                                    </td>
                                </tr>
                            @endif
                            @if(!empty($transaction->deducted_advance_amount))
                                <tr>
                                    <td class="text-right"><b>{{ __('text.adv_amount') }}</b></td>
                                    <td class="text-right">
                                        <b>{{ number_format(($transaction->deducted_advance_amount), 2) }}</b></td>
                                </tr>
                            @endif
                            @if( $grand_total > ($partial + $transaction->deducted_advance_amount))
                                <tr>
                                    <td class="text-right"><b>{{ __('text.due_amount') }}</b></td>
                                    <td class="text-right">
                                        <b>{{ number_format(($grand_total - ($partial + $transaction->deducted_advance_amount) ), 2) }}</b>
                                    </td>
                            @else
                                <tr>
                                    <td class="text-right"><b>{{ __('text.paid') }}</b></td>
                                    <td class="text-right"><b>{{ number_format(($grand_total), 2) }}</b></td>
                                </tr>
                            @endif
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
