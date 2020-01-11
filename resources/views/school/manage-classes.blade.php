@extends('layouts.student-app')

@section('title', 'Manage Classes')

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>
                <i class="fas fa-cog fa-fw"></i>
                Manage Classes
            </h3>
            <ul>
                <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                        Back &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ route(\Illuminate\Support\Facades\Auth::user()->role.'master.home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li>Manage Classes</li>
            </ul>
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
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
        <div class="false-height">
            <div class="card height-auto">
                <div class="card-body">
                    @include('school.new-manage-classes')
                </div>
            </div>
        </div>
    </div>
@endsection
