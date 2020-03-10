@extends('layouts.student-app')
@section('title', 'Account Sectors')
@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-file-invoice-dollar"></i>
            Add New Account Sector
        </h3>
        <ul>
            <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Add New Account Sector</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <!-- Admit Form Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <form class="new-added-form mb-5" action="{{url(\Illuminate\Support\Facades\Auth::user()->role.'/create-sector')}}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name">Sector Name <label class="text-danger">*</label></label>

                                <div class="">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ (!empty($sector->name))?$sector->name:old('name') }}" placeholder="Sector Name" required>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
                                <label for="type">Sector Type <label class="text-danger">*</label></label>

                                <div class="">
                                    <select  class="select2" name="type">
                                        <option value="expense">Expense</option>
                                        <option value="income">Income</option>
                                    </select>

                                    @if ($errors->has('type'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('type') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group mg-t-8">
                            <button type="submit" class="button button--save ml-4 mt-4">Save</button>
                        </div>
                    </div>
                </form>
            <div class="row mt-5">
                <div class="col-md-12">
                    <div class="height-auto">
                        <div class="">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="heading-layout1">
                                <div class="item-title">
                                    <h3>All Account Sectors</h3>
                                </div>
                            </div>
                            <table class="table table-bordered table-striped table-data-div">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sector Name</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($sectors as $index=>$sector)
                                    <tr>
                                        <td>{{ $index+1 }}</td>
                                        <td>{{$sector->name}}</td>
                                        <td>{{ucfirst($sector->type)}}</td>
                                        <td>
                                            <a href="{{url('accountant/edit-sector/'.$sector->id)}}" class="button button--edit mr-3" role="button"><b>Edit</b></a>
                                            <button class="button button--cancel" onclick="book({{ $sector->id }})">Delete</button>
                                            <form id="delete-form-{{ $sector->id }}" action="{{url(\Illuminate\Support\Facades\Auth::user()->role.'/delete-sector/'.$sector->id)}}" method="POST">
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
            console.log(id);
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
