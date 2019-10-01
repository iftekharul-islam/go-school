@extends('layouts.student-app')
@section('title', 'Fee Types')
@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Dashboard</h3>
            <ul>
                <li>
                    <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
                </li>
                <li>Fee Types</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-12 col-lg-8 col-xl-8 col-md-10">
                <div class="card false-height">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Create Fee Types</h3>
                            </div>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="mg-b-20" action="{{ url(auth()->user()->role.'/fee-types')  }}" method="post">
                            {{ csrf_field() }}
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="name">Name</label>
                                    <input type="text" placeholder="Name" class="form-control" name="name" value="{{ old('name') }}">
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
                                <button type="submit" class="button button--save">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection