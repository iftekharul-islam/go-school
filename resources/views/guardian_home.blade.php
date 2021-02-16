@extends('layouts.student-app')
@section('title','Dashboard')
@section('content')
    <div class="breadcrumbs-area">
        <h3>{{ __('text.Dashboard') }}</h3>
    </div>
    <!-- Breadcubs Area End Here -->
    <div class="false-height">
        <div class="row">
            <!-- All Notice Area Start Here -->
            <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>{{ __('text.Notices') }}</h3>
                            </div>
                        </div>
                        <div class="notice-board-wrap dashboard-notice">
                            @foreach($notices as $notice)
                                <div class="notice-list">
                                    <div class="row">
                                        <div class="col-9">
                                            <h6 class="notice-title" style="display: inline-block; padding-left: 20px;">
                                                <a href="{{ route('show.notice', $notice->id) }}"> {{$notice->title}} </a>
                                            </h6>
                                        </div>
                                        <div class="col-3">
                                            <div  style="display: inline-block;">{{ date('d-m-Y', strtotime($notice->created_at)) }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>{{ __('text.events') }}</h3>
                            </div>
                        </div>
                        <div class="notice-board-wrap dashboard-notice">
                            @foreach($events as $event)
                                <div class="notice-list">
                                    <div class="row">
                                        <div class="col-9">
                                            <h6 class="notice-title" style="display: inline-block; padding-left: 20px;">
                                                <a href="{{ url($event->file_path) }}" target="_blank"> {{$event->title}} </a>
                                            </h6>
                                        </div>
                                        <div class="col-3">
                                            <div class="" style="display: inline-block;">{{ date('d-m-Y', strtotime($event->created_at)) }}</div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-lg-12 col-md-12 col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>{{ __('text.my_child') }}</h3>
                            </div>
                        </div>
                        @if($users->isNotEmpty())
                            <div class="table-responsive mt-5">
                                <table class="table table-bordered display text-wrap">
                                    <thead>
                                    <tr>
                                        <th>{{ __('text.Code') }}</th>
                                        <th>{{ __('text.Name') }}</th>
                                        <th>{{ __('text.Class') }}</th>
                                        <th>{{ __('text.Section') }}</th>
                                        <th>{{ __('text.action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->student->student_code }}</td>
                                            <td>{{ $user->student->name }}</td>
                                            <td>{{ $user->student->section->class->class_number }}</td>
                                            <td>{{ $user->student->section->section_number }}</td>
                                            <td><a href="{{ route('child.show', $user->student->id) }}"
                                                   class="btn btn-success"><i class="fas fa-eye"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-3 col-sm-12">
                                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }}
                                    of {{ $users->total() }}
                                </div>
                                <div class="col-md-9 col-sm-12 text-right">
                                    <div class="paginate123 float-right">
                                        {{ $users->appends(request()->query())->links() }}
                                    </div>
                                </div>
                            </div>

                    </div>
                    @else
                        <p class="text-center">{{ __('text.No_related_data_notification') }}</p>
                    @endif
                </div>
            </div>

        </div>

    </div>
@endsection
