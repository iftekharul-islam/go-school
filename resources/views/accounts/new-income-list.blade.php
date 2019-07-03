@extends('layouts.student-app')
@section('title', 'Income List')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet">

<div class="breadcrumbs-area">
    <h3>
        </a>List of Income
    </h3>
    <ul>
        <li> <a href="javascript:history.back()" style="color: #32998f!important;">
                Back &nbsp;&nbsp;|</a>
            <a style="margin-left: 8px;" href="{{ url('/home') }}">&nbsp;&nbsp;Home</a>
        </li>
        <li>List of Income</li>
    </ul>
</div>

<div class="card height-auto">
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="row mb-5">
            <div class="col-md-6">
                <form class="new-added-form" action="{{url('/accounts/list-income')}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                            <label for="year" class="col-md-12">Year</label>
                            <div class="col-md-12">
                                <select class="select2 select2-hidden-accessible" data-select2-id="4" tabindex="-1" aria-hidden="true" name="year">
                                    <option value="">Please Select Year</option>
                                    <option value="2019">2019</option>
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                </select>
                                {{--                            <input data-date-format="yyyy" id="year" class="form-control date" name="year" value="{{ old('year') }}" placeholder="Year12" required autocomplete="off">--}}
                                @if ($errors->has('year'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('year') }}</strong>
                                  </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('month') ? ' has-error' : '' }}">
                            <label for="year" class="col-md-12">Month</label>
                            <div class="col-md-12">
                                <select class="select2 select2-hidden-accessible" data-select2-id="7" tabindex="-1" aria-hidden="true" name="month">
                                    <option value="">Please Select Month</option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                                {{--                            <input data-date-format="mm" id="month" class="form-control date" name="month" value="{{ old('month') }}" placeholder="Month" autocomplete="off">--}}
                                @if ($errors->has('month'))
                                    <span class="help-block">
                                      <strong>{{ $errors->first('month') }}</strong>
                                  </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="button button--text float-left"><b>Get Income List</b></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <div style="width:100%; height: 300px;">
                    <canvas id="canvas"></canvas>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-md-12">
                    @isset($incomes)
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table display text-wrap">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Sector Name</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Year</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($incomes as $income)
                                        <tr>
                                            <td>{{($loop->index + 1)}}</td>
                                            <td>{{$income->name}}</td>
                                            <td>{{$income->amount}}</td>
                                            <td>{{$income->description}}</td>
                                            <td>{{ Carbon\Carbon::parse($income->created_at)->format('Y')}}</td>
                                            <td><a title='Edit' class='button button--text float-left' href='{{url("accounts/edit-income")}}/{{$income->id}}'><b>Edit</b></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endisset
                </div>
            </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function () {
        $('.date').datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years"
        });
    })
</script>
<script>
$('.datepicker').datepicker({
  format: 'yyyy',
  viewMode: "years",
  minViewMode: "years",
  autoclose:true,
});
$("#btnPrint").on("click", function () {
            var divContents = $("#printDiv").html();
            var printWindow = window.open('', '', 'height=400,width=800');
            printWindow.document.write('<html><head><title>Income List</title>');
            printWindow.document.write('</head><body>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.document.body.innerHTML = divContents;
            printWindow.print();
        });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
	<style>
		canvas {
			-moz-user-select: none;
			-webkit-user-select: none;
			-ms-user-select: none;
		}
    </style>
    <script>
        'use strict';

        window.chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(201, 203, 207)'
        };

		var color = Chart.helpers.color;
		var config = {
			type: 'bar',
			data: {
				datasets: [{
                    label: 'Income',
					backgroundColor: color(window.chartColors.green).alpha(0.5).rgbString(),
					borderColor: window.chartColors.green,
					fill: false,
					data: [@foreach($incomes as $s)
                        {
                            t:"{{Carbon\Carbon::parse($s->created_at)->format('Y-d-m')}}",
                            y:{{$s->amount}}
                        },
                        @endforeach]
        }]
                },
			options: {
				title: {
                    display: true,
					text: 'Income (In Dollar) in Time Scale'
				},
        maintainAspectRatio: false,
				scales: {
					xAxes: [{
						type: 'time',
						time: {
							parser: 'YYYY-DD-MM',
							tooltipFormat: 'll HH:mm'
						},
						scaleLabel: {
							display: true,
							labelString: 'Date'
						}
					}],
					yAxes: [{
						scaleLabel: {
							display: true,
							labelString: 'Money'
						}
					}]
				},
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = new Chart(ctx, config);

		};
	    </script>
@endsection
