@extends('layouts.student-app')
@section('title', 'Account Sectors')
@section('content')
    <div class="breadcrumbs-area">
        <div class="breadcrumbs-area">
            <h3><a href="javascript:history.back()" class="float-left"><h4 style="color: #fea801; font-size: 22px;">Back</h4></a>&nbsp;&nbsp;Add New Sector</h3>
            <ul style="margin-left: -100px !important;">
                <li>
                    <a style="margin-left: -43px;" href="{{ url('/home') }}">Home</a>
                </li>
                <li>Add New Sector</li>
            </ul>
        </div>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Admit Form Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form class="new-added-form" action="{{url('/accounts/create-sector')}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Sector Name</label>

                            <div class="">
                                <input id="name" type="text" class="form-control" name="name" value="{{ (!empty($sector->name))?$sector->name:old('name') }}" placeholder="Sector Name" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                            <label for="type">Sector Type</label>

                            <div class="">
                                <select  class="form-control" name="type">
                                    <option value="income">Income</option>
                                    <option value="expense">Expense</option>
                                </select>

                                @if ($errors->has('type'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Save</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div style="width:100%;">
                        <canvas id="canvas"></canvas>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="card height-auto">
                        <div class="card-body">
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>All Created Sectors</h3>
                                </div>
                            </div>
                            <table class="table table-striped table-data-div">
                                <thead>
                                <tr>
                                    <th>Sector Name</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($sectors as $sector)
                                    <tr>
                                        <td>{{$sector->name}}</td>
                                        <td>{{ucfirst($sector->type)}}</td>
                                        <td>
                                            <a href="{{url('accounts/edit-sector/'.$sector->id)}}" class="btn btn-warning btn-lg mr-3" role="button">Edit</a>
                                            <button class="btn btn-danger btn-lg" onclick="book()">Delete</button>
                                            <a id="delete-form" href="{{url('accounts/delete-sector/'.$sector->id)}}" role="button"></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                },{
                    label: 'Expense',
					backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
					borderColor: window.chartColors.red,
					fill: false,
					data: [@foreach($expenses as $s)
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
					text: 'Income and Expense (In Dollar) in Time Scale'
				},
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
@push('customjs')
    <script type="text/javascript">
        function book(id) {
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
                    } else {
                        swal("Your Delete Operation has been canceled");
                    }
                });
        }
    </script>
@endpush