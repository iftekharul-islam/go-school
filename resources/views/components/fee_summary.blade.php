<table class="table table-bordered ">
    <thead>
    <tr>
        <th colspan="2">{{ __('text.fee_details') }}</th>
        <th colspan="5">{{ __('text.payment_condition') }}</th>
    </tr>
    </thead>

    <tbody>
    <tr>
        <th>{{ __('text.fee_name') }}</th>
        <th>{{ __('text.amount') }}</th>
        <th>{{ __('text.status') }}</th>
        <th>{{ __('text.paid_date') }}</th>
        <th>{{ __('text.last_date') }}</th>
        <th>{{ __('text.paid') }}</th>
        <th>{{ __('text.balance') }}</th>
    </tr>
    @isset($student->section->class)
        @foreach($student->section->class->feeMasters as $feeMaster)
            <tr>
                <td class="text-capitalize"><span
                        class="badge-success badge month"></span> {{ $feeMaster->feeType['name'] }}
                </td>
                <td>{{ $feeMaster->amount }}</td>
                <td>
                    @if($totalFeePaid >= $feeMaster->amount)
                        <span class="badge-primary badge paid">Paid</span>
                    @elseif($totalFeePaid > 0 && $totalFeePaid < $feeMaster->amount)
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
                    {{number_format((float)($paidAmount), 2, '.', '')}}
                </td>
                <td>{{number_format((float)($feeMaster->amount - $paidAmount), 2, '.', '')}}</td>
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
