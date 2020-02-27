@extends('layouts.student-app')
@section('title', 'Edit Fee Types')
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Edit Fee Type</h3>
            <ul>
                <li>
                    <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
                </li>
                @if(Auth::user()->role != 'master')
                <li>Manage Accounts</li>
                <li>Fee Collection</li>
                <li> <a href="{{ route('fee-types.index') }}">Fee Types</a></li>
                @else 
                <li>Default Fee Types</li>
                @endif
                <li>Edit Fee Type</li>
            </ul>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-12 col-lg-8 col-xl-8 col-md-10">
                <div class="card false-height">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Edit Fee Types</h3>
                            </div>
                        </div>
                        <form class="mg-b-20" action="@if(auth()->user()->role == 'master') {{ route('update.fee.type',['id' => $feeType->id])}} @else {{ url(auth()->user()->role.'/fee-types', $feeType->id) }} @endif" method="POST">
                            {{ csrf_field() }}
                            {!! method_field('patch') !!}
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="name">Name</label>
                                    <input type="text" placeholder="Name" class="form-control" name="name" value="{{ $feeType->name }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="code">Code</label>
                                    <input type="text" placeholder="Code" class="form-control" name="code" value="{{ $feeType->code }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="desc">Description</label>
                                    <textarea class="form-control" placeholder="Description" name="desc">{{ $feeType->description }}</textarea>
                                </div>
                            </div>
                            <div class="form-group mr-4 float-right mt-3">
                                <button type="submit" class="button button--save">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection