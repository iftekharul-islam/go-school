<div class="table-responsive text-center">
    <table class="table display table-bordered table-hover  text-wrap table-sm">
        <thead>
        <tr>
            <th>{{ __('text.transaction_no') }}.</th>
            <th>{{ __('text.type') }}</th>
            <th>{{ __('text.Date') }}</th>
            <th>{{ __('text.action') }}</th>
        </tr>
        </thead>
        <tbody>
        @if(!$fees->isEmpty())
            @foreach($fees as $fee)
                <tr>
                    <td>{{ $fee->transaction_serial }}</td>
                    <td>{{ $fee->mode }}</td>
                    <td>{{ $fee->created_at->format('Y-m-d') }}</td>
                    <td>
                        <button title="Cancel Transaction" class="btn btn-danger" onclick="feeTransaction({{ $fee->id }})"><i class="fas fa-trash"></i></button>&nbsp;
                        <a  title="View Transaction Details" class="btn btn-primary" href="{{ url(auth()->user()->role.'/transaction-detail/'.$fee->id) }}"><i class="fas fa-eye"></i></a>
                        <form id="delete-form-{{ $fee->id }}" action="{{ url(auth()->user()->role.'/fee-transaction', $fee->id) }}" method="POST">
                            {!! method_field('delete') !!}
                            {!! csrf_field() !!}
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>
