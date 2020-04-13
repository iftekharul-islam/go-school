@extends('layouts.student-app')
@section('title', 'Expense List')
@section('content')
{{--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet">--}}
<style>
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
        .expense-report {
            padding-bottom: 20px !important;
        }
    }
</style>
<div class="breadcrumbs-area example-screen">
    <h3>
        <i class="fas fa-file-invoice-dollar"></i>
        {{ __('text.expense_list') }}
    </h3>
    <ul>
        <li>
            <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                {{ __('text.Back') }} &nbsp;&nbsp;|</a>
            <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
        </li>
        <li>{{ __('text.expense_list') }}</li>
    </ul>
</div>
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<div class="card height-auto">
    <div class="card-body">
        <div class="example-screen">
            <div class="row">
                <div class="col-md-6">
                    <form class="form-horizontal" action="{{url(\Illuminate\Support\Facades\Auth::user()->role.'/list-expense')}}" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group{{ $errors->has('from_date') ? ' has-error' : '' }}">
                                <label for="year" class="col-md-12">{{ __('text.From Date') }}</label>
                                <div class="col-md-12">
                                    <input data-date-format="yyyy-mm-dd" id="datePicker" class="form-control date" name="from_date" value="{{ $from ?? \Carbon\Carbon::now()->format('Y-m-d') }}" placeholder="" required>
                                    @if ($errors->has('from_date'))
                                        <span class="help-block">
                                          <strong>{{ $errors->first('from_date') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('to_date') ? ' has-error' : '' }}">
                                <label for="year" class="col-md-12">{{ __('text.End Date') }}</label>
                                <div class="col-md-12">
                                    <input data-date-format="yyyy-mm-dd" id="datePicker" class="form-control date" name="to_date" value="{{ $to ?? \Carbon\Carbon::now()->format('Y-m-d') }}" placeholder="From Date" required>
                                    @if ($errors->has('to_date'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('to_date') }}</strong>
                                  </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8" style="margin-left: -12px;">
                                <button type="submit" class="button button--save float-left mb-5 mt-4">{{ __('text.expense_list') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-secondary float-right mb-2" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
                    @isset($expenses)
                        <div class="table-responsive">
                            <table class="table table-bordered display text-wrap">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('text.sector_name') }}</th>
                                    <th style="width: 40%">{{ __('text.description') }}</th>
                                    <th>{{ __('text.Date') }}</th>
                                    <th>{{ __('text.amount') }}</th>
                                    <th>{{ __('text.active') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $grand_total = 0;
                                @endphp
                                @foreach($expenses as $expense)
                                    <tr>
                                        @php
                                            $grand_total = $grand_total + $expense->amount ;
                                        @endphp
                                        <td>{{($loop->index + 1)}}</td>
                                        <td>{{$expense->name}}</td>
                                        <td>{{$expense->description}}</td>
                                        <td>{{ $expense->date }}</td>
                                        <td>{{$expense->amount}}</td>
                                        <td>
                                            <a title='Edit' class='btn btn-primary btn-lg' href='{{url(\Illuminate\Support\Facades\Auth::user()->role."/edit-expense")}}/{{$expense->id}}'><i class="fa fa-edit"></i></a>
                                            <a class="btn btn-danger btn-lg text-white ml-2" type="button" onclick="deleteMsg({{ $expense->id }})"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                        <form id="delete-form-{{ $expense->id }}" action="{{ url( \Illuminate\Support\Facades\Auth::user()->role . '/delete-expense/' . $expense->id) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                        </form>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><b>Grand Total</b></td>
                                    <td><b>{{ $grand_total }}</b></td>
                                </tr>
                                </tbody>
                            </table>
                            <br>
                        </div>
                    @endisset
                </div>
            </div>
        </div>

        <div class="example-print">
            <div class="school-property mb-5">
                <h1 class="text-center mb-0">{{ auth()->user()->school->name }}</h1>
                <h4 class="text-center">{{ auth()->user()->school->school_address }}</h4>
            </div>
            <div class="expense-report">
                <h3 class="mb-0">Expense Statement
                    @if(isset($from) || isset($to))
                        From @if(isset($from)){{ ucfirst(strftime("%D", strtotime( $from ))) }}@endif To @if(isset($to)){{ ucfirst(strftime("%D", strtotime( $from ))) }}@endif
                    @else
                        Of this year
                    @endif
                </h3>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @isset($expenses)
                        <div class="table-responsive">
                            <table class="table table-bordered display text-wrap">
                                <thead>
                                <tr>
                                    <th>Sector Name</th>
                                    <th style="width: 40%">Description</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $grand_total = 0;
                                @endphp
                                @foreach($expenses as $expense)
                                    <tr>
                                        @php
                                            $grand_total = $grand_total + $expense->amount ;
                                        @endphp
                                        <td>{{$expense->name}}</td>
                                        <td>{{$expense->description}}</td>
                                        <td>{{ $expense->date }}</td>
                                        <td>{{$expense->amount}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><b>Grand Total</b></td>
                                    <td><b>{{ $grand_total }}</b></td>
                                </tr>
                                </tbody>
                            </table>
                            <br>
                        </div>
                    @endisset
                </div>
            </div>
            <div class="signature" style="margin: 100px 0 0 40px;">
                <hr style="width: 30%; margin-left: -10px; display: block;border-width: 1.4px; border-color: #000000">
                <p style="margin-left: 50px;">Signature of Accountant</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('customjs')
    <script>
        $( document ).ready(function() {
            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

            var optSimple = {
                format: 'mm-dd-yyyy',
                todayHighlight: true,
                orientation: 'bottom right',
                autoclose: true,
                container: '#sandbox'
            };
            $( '.form_date' ).datepicker( optSimple );
            $( '.to_date' ).datepicker( optSimple );
        });

        function deleteMsg(id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Expense!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        document.getElementById('delete-form-'+id).submit();
                    }
                });
        }
    </script>
@endpush
