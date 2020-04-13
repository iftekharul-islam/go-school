@extends('layouts.student-app')
@section('title', 'Fee Discount')
@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>{{ __('text.discounts') }}</h3>
            <ul>
                <li>
                    <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                        {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
                </li>
                <li>{{ __('text.discounts') }}</li>
            </ul>
        </div>
        <div class="card height-auto false-height">
            <div class="card-body">
                <div class="heading-layout1">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="item-title">
                        <h3 class="float-left mb-5">{{ __('text.fee_discount') }}</h3>
                        <a href="{{ url(auth()->user()->role.'/fee-discount/create') }}" class="button button--save float-right">{{ __('text.add_discount') }}</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table display text-wrap">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('text.Name') }}</th>
                            <th>{{ __('text.Code') }}</th>
                            <th>{{ __('text.amount') }}</th>
                            <th>{{ __('text.type') }}</th>
                            <th width="40%">{{ __('text.description') }}</th>
                            <th>{{ __('text.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($discounts as $discount)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $discount->name }}</td>
                                <td>{{ $discount->code }}</td>
                                <td>{{ $discount->amount }}</td>
                                <td>{{ $discount->type }}</td>
                                <td>{{ $discount->description }}</td>
                                <td>
                                    <a href="{{ url(auth()->user()->role.'/fee-discount/'.$discount->id.'/edit') }}" class="button button--save mr-3"><i class="far fa-edit"></i></a>
                                    <button class="button button--cancel" onclick="feeDiscount({{ $discount->id }})"><i class="far fa-trash-alt"></i></button>
                                    <form id="delete-form-{{ $discount->id }}" action="{{ url(auth()->user()->role.'/fee-discount', $discount->id) }}" method="POST">
                                        {!! method_field('delete') !!}
                                        {!! csrf_field() !!}
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customjs')
    <script type="text/javascript">
        function feeDiscount(id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this file!",
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
        }
    </script>
@endpush
