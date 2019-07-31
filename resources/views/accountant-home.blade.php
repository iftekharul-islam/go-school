@extends('layouts.student-app')
@section('title','Dashboard')
@section('content')
    <div class="breadcrumbs-area">
        <h3>Dashboard</h3>
        <ul>
            <li>
                <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
            </li>
            <li class="text-capitalize">{{ \Auth::user()->role }} Dashboard</li>
        </ul>
    </div>
    <!-- Breadcubs Area End Here -->
    <div class="false-height">
        <div class="row">
            <!-- Dashboard summery Start Here -->
            <div class="col-12 col-4-xxxl">
                <div class="row">
                    <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                        <div class="dashboard-summery-two">
                            <div class="item-icon bg-light-magenta">
                                <i class="flaticon-classmates text-magenta"></i>
                            </div>
                            <div class="item-content">
                                <div class="item-number"><span class="counter" data-num="{{ $totalStudents }}"></span></div>
                                <div class="item-title">Total Students</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                        <div class="dashboard-summery-two">
                            <div class="item-icon bg-light-blue">
                                <i class="flaticon-shopping-list text-blue"></i>
                            </div>
                            <div class="item-content">
                                <div class="item-number"><span class="counter" data-num="{{ $exams->count() }}"></span></div>
                                <div class="item-title">Total Exams</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                        <div class="dashboard-summery-two">
                            <div class="item-icon bg-light-yellow">
                                <i class="flaticon-maths-class-materials-cross-of-a-pencil-and-a-ruler text-green"></i>
                            </div>
                            <div class="item-content">
                                <div class="item-number"><span class="counter" data-num="{{ $totalClasses }}"></span></div>
                                <div class="item-title">Total Classes</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6-xxxl col-lg-3 col-sm-6 col-12">
                        <div class="dashboard-summery-two">
                            <div class="item-icon bg-light-red">
                                <i class="flaticon-books text-blue"></i>
                            </div>
                            <div class="item-content">
                                <div class="item-number"><span class="counter" data-num="{{ $totalSections }}"></span></div>
                                <div class="item-title">Total Sections</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dashboard summery End Here -->
            <!-- Students Chart End Here -->
            <div class="col-lg-6 col-4-xxxl col-xl-6">
                <div class="card dashboard-card-three" style="min-height: 484px !important;">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Profit</h3>
                            </div>
                        </div>
                        <div class="doughnut-chart-wrap">
                            <canvas id="student-doughnut-chart2" width="100" height="270"></canvas>
                        </div>
                        <div class="student-report">
                            <div class="student-count pseudo-bg-blue">
                                <h4 class="item-title">Income</h4>
                                <div class="item-number">{{ $total_income }}</div>
                            </div>
                            <div class="student-count pseudo-bg-yellow">
                                <h4 class="item-title">Expense</h4>
                                <div class="item-number">{{ $total_expense }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Students Chart End Here -->
            <!-- Notice Board Start Here -->
            <div class="col-lg-6 col-4-xxxl col-xl-6">
                <div class="card dashboard-card-six" style="min-height: 484px !important;">
                    <div class="card-body">
                        <div class="heading-layout1 mg-b-17">
                            <div class="item-title">
                                <h3>Notices</h3>
                            </div>
                        </div>
                        <div class="notice-box-wrap">
                            @foreach($notices as $notice)
                                <div class="notice-list">
                                    <div class="row">
                                        <div class="col-8">
                                            <h6 class="notice-title"><a href="{{ url($notice->file_path) }}">{{ $notice->title }}</a></h6>
                                        </div>
                                        <div class="col-4">
                                            <div class="">{{ date('d-m-Y', strtotime($notice->created_at)) }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- Notice Board End Here -->
        </div>
        <div class="card">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>All Fees</h3>
                    </div>
                </div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                    <div class="table-responsive">
                        <table class="table data-table text-nowrap">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Fee Name</th>
                                <th>Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($fees as $key => $fee)
                                <tr>
                                    <td>{{($loop->index + 1)}}</td>
                                    <td>{{$fee->fee_name}}</td>
                                    <td>
                                        <form class="form-group" id="delete-form-{{$fee->id}}" action="{{ url('accountant/fees/remove', ['id' => $fee->id]) }}" method="post">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                        </form>
                                        <button class="button button--cancel" onclick="book({{$fee->id}})">Delete</button>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
            </div>
        </div>
    </div>
    <script>
        function book(id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        document.getElementById('delete-form-'+id).submit();
                        setTimeout(5000);
                        swal("Poof! Your Selected data has been deleted!", {
                            icon: "success",
                        });
                    }
                });
        }
        var income = @json($total_income);
        var expense = @json($total_expense);
    </script>
@endsection