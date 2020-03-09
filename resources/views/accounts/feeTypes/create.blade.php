@extends('layouts.student-app')
@section('title', 'Fee Types')
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Create Fee Type</h3>
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
                <li>Create Fee Type</li>
            </ul>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8 col-xl-8 col-md-12">
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
                <div class="card false-height">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Create Fee Types</h3>
                            </div>
                        </div>
                        <form class="mg-b-20" action="@if(auth()->user()->role == 'master') {{ route('store.fee.type')}} @else {{ url(auth()->user()->role.'/fee-types')  }} @endif" method="post">
                            {{ csrf_field() }}
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="name">Name</label>
                                    <input type="text" placeholder="Name" class="form-control" name="name" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">

                                    <label for="type"> <input type="checkbox" value="1" name="type" id="type" @if( old('type') == 1) checked @endif> Is Monthly Fee</label>&nbsp;

{{--                                    <select class="form-control" name="type">--}}
{{--                                        --}}
{{--                                        <option value="onetime" @if( old('type') == 'onetime') selected @endif>One Time</option>--}}
{{--                                        <option value="monthly" @if( old('type') == 'monthly') selected @endif>Monthly</option>--}}
{{--                                    </select>--}}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="code">Code</label>
                                    <input type="text" placeholder="Code" class="form-control" name="code" value="{{ old('code') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="desc">Description</label>
                                    <textarea class="form-control" placeholder="Description" name="desc"></textarea>
                                </div>
                            </div>
                            <div class="form-group mr-4 float-right mt-3">
                                <button type="submit" class="button button--save">Add Fee Type</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
