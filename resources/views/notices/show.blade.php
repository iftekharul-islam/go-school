@extends('layouts.student-app')
@section('title', $notice->title)
@section('content')
    <div class="container-fluid">
        <div class="breadcrumbs-area">
            <h3>
                Notice Details
            </h3>
            <ul>
                <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
                        Back &nbsp;&nbsp;|</a>
                    <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li class="text-capitalize">Notice Details</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- Student Details Area Start Here -->
        <div>
            @if (!empty($notice))
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card dashboard-card-three equal-size-body" >
                            <div class="card-body" >
                                <div class="heading-sub fancy4">{{ $notice->title }}</div>
                                <small>{{  $notice->created_at->format('d M Y') }}</small>
                                <h3 class="text-center">
                                    {{ $notice->title }}
                                </h3>
                                <div class="">
                                    {!! $notice->description ? $notice->description : Null !!}
                                </div>
                                @if (!empty($notice->file_path))
                                    <div class="mt-5">
                                    <a class="button button--save mr-2" href="{{url($notice['file_path'])}}" target="_blank">Show Attachment</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card dashboard-card-six">
                            <div class="card-body">
                                <div class="heading-layout1 mg-b-17">
                                    <div class="item-title">
                                        <h3>Notices</h3>
                                    </div>
                                </div>
                                <div class="notice-box-wrap">
                                    @foreach ($notices as $notice)
                                        <div class="notice-list">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h6 class="notice-title"><a href="{{ route('show.notice', $notice->id) }}">{{ $notice->title }}</a></h6>
                                                    <small>{{ $notice->created_at->format('d M Y') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @else
            <div class="card mt-5 false-height">
                <div class="card-body">
                    <div class="card-body-body mt-5 text-center">
                        No Related Data Found.
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

@endsection
