@extends('layouts.student-app')
@section('title', 'Fee Discounts')
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Dashboard</h3>
            <ul>
                <li>
                    <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
                </li>
                <li>Fee Discounts</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-12 col-lg-8 col-xl-8 col-md-10">
                <div class="card false-height">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Create Fee Discount</h3>
                            </div>
                        </div>
                        <form class="mg-b-20" action="{{ url(auth()->user()->role.'/fee-discount') }}" method="post">
                            {{ csrf_field() }}
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="name">Name</label>
                                    <input type="text" placeholder="Name" class="form-control" name="name" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="code">Code</label>
                                    <input type="text" placeholder="Code" class="form-control" name="code" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="code">Discount Type</label>
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <p>Monthly Discount will applicable for every payment</p>
                                        <p>One time Amount will cut only once from total amount</p>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <select name="discount_type" id="" class="select2">
                                        <option value="" selected>Select Discount</option>
                                        <option value="recurrent">Monthly</option>
                                        <option value="onetime">One Time</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="code">Amount</label>
                                    <input type="number" step="0.01" placeholder="Amount" class="form-control" name="amount" value="{{ old('amount') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="desc">Description</label>
                                    <textarea class="form-control" placeholder="Description" name="desc"></textarea>
                                </div>
                            </div>
                            <div class="form-group mr-4 float-right mt-3">
                                <button type="submit" class="button button--save">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection