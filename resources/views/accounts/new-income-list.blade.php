@extends('layouts.student-app')
@section('title', 'Income List')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css" rel="stylesheet">

<div class="breadcrumbs-area">
    <h3>Dashboard</h3>
    <ul>
        <li>
            <a href="{{ url('/home') }}">Home</a>
        </li>
        <li>View List of Income</li>
    </ul>
</div>

<div class="card height-auto">
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="heading-layout1">
            <div class="item-title">
                <a class="float-left" href="{{ url()->previous() }}"><h4 style="color: #fea801; margin-left: 8px;">Back</h4></a>
                <h3>View List of Income</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form class="form-horizontal" action="{{url('/accounts/list-income')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }}">
                        <label for="year" class="col-md-4">Year</label>

                        <div class="col-md-12">
                            <input id="date" type="text" class="form-control" name="year" value="{{ old('year') }}" placeholder="Year" required>

                            @if ($errors->has('year'))
                                <span class="help-block">
                                      <strong>{{ $errors->first('year') }}</strong>
                                  </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-primary btn">Get Income List</button>
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
                                            <td><a title='Edit' class='btn btn-info btn-sm' href='{{url("accounts/edit-income")}}/{{$income->id}}'>Edit</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div id="printDiv"  class="visible-print">
                                <h2 style="text-align:center;">{{Auth::user()->school->name}}</h2>
                                <h4 style="text-align:center;">Expense List</h4>
                                <div class="table-responsive">
                                    <table class="table display text-wrap">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Sector Name</th>
                                            <th>Amount</th>
                                            <th>Description</th>
                                            <th>Year</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($incomes as $income)
                                            <tr>
                                                <td>{{($loop->index + 1)}}</td>
                                                <td>{{$income->name}}</td>
                                                <td>{{$income->amount}}</td>
                                                <td>{{$income->description}}</td>
                                                <td>{{Carbon\Carbon::parse($income->created_at)->format('Y')}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endisset
                </div>
            </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
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