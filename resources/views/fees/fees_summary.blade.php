@extends('layouts.student-app')

@section('title', 'Fees Summary')

@section('content')
    <!-- Breadcubs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>
            {{ __('text.fees_summary') }}
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}">
                    Back &nbsp;&nbsp;|</a>
                <a href="{{ url( current_user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>{{ __('text.fees_summary') }}</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->

    <!-- All Subjects Area Start Here -->
    <div class="row">
        <div class="col-12-xxxl col-12">
            <div class="card false-height">
                <div class="card-body">
                    <div class="card-body-body mb-5 text-center">

                        <div class="table-responsive">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- All Subjects Area End Here -->

@endsection
