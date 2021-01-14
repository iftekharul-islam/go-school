@extends('layouts.student-app')
@section('title', 'Income List')
@section('content')
    <style>
        .example-print {
            display: none;
        }
        @media print {
            .example-screen {
                display: none;
            }

            .example-print {
                margin: 25mm 0 0 0;
                display: block;
            }
            .income-report {
                padding-bottom: 20px !important;
            }
        }
    </style>
<div class="breadcrumbs-area example-screen">
    <h3>
        <i class="fas fa-file-invoice-dollar"></i>
        {{ __('text.Income List') }}
    </h3>
    <ul>
        <li>
            <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                {{ __('text.Back') }} &nbsp;&nbsp;|</a>
            <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
        </li>
        <li>{{ __('text.Income List') }}</li>
    </ul>
</div>

<div class="card height-auto">
    <div class="example-screen">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="row mb-5">
                <div class="col-md-12 ">
                    <form class="new-added-form" action="{{url(\Illuminate\Support\Facades\Auth::user()->role.'/list-income')}}" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">

                                <div class="col-md-12">
                                    <label for="from_date">{{ __('text.Start Date') }}</label>
                                    <input data-date-format="yyyy-mm-dd" id="datePicker1" class="form-control date" name="from_date" value="{{ $from ?? \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                    @if ($errors->has('from_date'))
                                        <span class="help-block">
                                      <strong>{{ $errors->first('from_date') }}</strong>
                                  </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('month') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <label for="year">{{ __('text.End Date') }}</label>
                                    <input data-date-format="yyyy-mm-dd" id="datePicker1" class="form-control date" name="to_date" value="{{ $to ??  \Carbon\Carbon::now()->format('Y-m-d') }}" required>
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
                                <button type="submit" class="button button--save float-left">{{ __('text.Income List') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-secondary float-right mb-3" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
                    @isset($incomes)
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-bordered display text-wrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('text.sector_name') }}</th>
                                        <th style="width: 40%">{{ __('text.description') }}</th>
                                        <th>{{ __('text.Date') }}</th>
                                        <th>{{ __('text.amount') }}</th>
                                        <th>{{ __('text.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $grand_total = 0;
                                        $loop_ind = 1;
                                    @endphp
                                    @foreach($incomes as $income)
                                        <tr>
                                            @php
                                                $grand_total = $grand_total + $income->amount ;
                                                $loop_ind ++;
                                            @endphp
                                            <td>{{($loop->index + 1)}}</td>
                                            <td>{{$income->name}}</td>
                                            <td>{{$income->description}}</td>
                                            <td>{{ $income->date }}</td>
                                            <td>{{$income->amount}}</td>
                                            <td>
                                                <a title='Edit' class='btn btn-success btn-lg' href='{{url(\Illuminate\Support\Facades\Auth::user()->role."/edit-income")}}/{{$income->id}}'><i class="fa-edit fa"></i></a>
                                                <a class="btn btn-danger btn-lg text-white ml-2" type="button" onclick="deleteMsg({{ $income->id }})"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                            <form id="delete-form-{{ $income->id }}" action="{{ url( \Illuminate\Support\Facades\Auth::user()->role . '/delete-income/' . $income->id) }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                            </form>
                                        </tr>
                                    @endforeach
                                    @if(isset($student_total))
                                        <tr>
                                            @php
                                                $grand_total = $grand_total + $student_total ;
                                            @endphp
                                            <td>{{ $loop_ind }}</td>
                                            <td>Student Fee Collection</td>
                                            <td>Total student Fee collection</td>
                                            <td></td>
                                            <td>{{ $student_total }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><b>{{ __('text.grand_total') }}</b></td>
                                        <td><b>{{ $grand_total }}</b></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
    <div class="example-print">
        <div class="income-report">
            <div class="school-property mb-5">
                <h1 class="text-center mb-0">{{ auth()->user()->school->name }}</h1>
                <h4 class="text-center">{{ auth()->user()->school->school_address }}</h4>
            </div>
            <h3>Income Statement
                @if(isset($from) || isset($to))
                    From @if(isset($from)){{ ucfirst(strftime("%D", strtotime( $from ))) }}@endif To @if(isset($to)){{ ucfirst(strftime("%D", strtotime( $from ))) }}@endif
                @else
                    Of this year
                @endif
            </h3>
        </div>
        <div class="row">
            <div class="col-md-12">
                @isset($incomes)
                    <div class="table-responsive">
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
                                @foreach($incomes as $income)
                                    <tr>
                                        @php
                                            $grand_total = $grand_total + $income->amount ;
                                        @endphp
                                        <td>{{$income->name}}</td>
                                        <td>{{$income->description}}</td>
                                        <td>{{ $income->date }}</td>
                                        <td>{{$income->amount}}</td>
                                    </tr>
                                @endforeach
                                @if(isset($student_total))
                                    <tr>
                                        @php
                                            $grand_total = $grand_total + $student_total ;
                                        @endphp
                                        <td>Student Fee Collection</td>
                                        <td>Total student Fee collection</td>
                                        <td></td>
                                        <td>{{ $student_total }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><b>Grand Total</b></td>
                                    <td><b>{{ $grand_total }}</b></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endisset
            </div>
        </div>
        <div class="signature" style="margin: 100px 0 0 0;">
            <hr style="width: 30%; margin-left: -10px; display: block;border-width: 1.4px; border-color: #000000">
            <p style="margin-left: 50px;">Signature of Accountant</p>
        </div>
    </div>
</div>
@endsection
@push('customjs')
    <script>
        $( document ).ready(function() {
            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

            var optSimple1 = {
                format: 'mm-dd-yyyy',
                todayHighlight: true,
                orientation: 'bottom right',
                autoclose: true,
                container: '#sandbox'
            };
        });

        function deleteMsg(id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this Income!",
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
