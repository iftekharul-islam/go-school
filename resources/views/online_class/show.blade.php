@extends('layouts.student-app')
@section('title', 'Online class summary')
@section('content')
    <div class="container-fluid">
        <div class="breadcrumbs-area">
            <h3>
                {{ __('text.online_class_summary') }}
            </h3>
            <ul>
                <li> <a href="{{ URL::previous() }}">
                        Back &nbsp;&nbsp;|</a>
                    <a href="{{ url(current_user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
                </li>
                <li class="text-capitalize">{{ __('text.online_class_summary') }}</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- Student Details Area Start Here -->
        <div>
            @if (!empty($data))
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card dashboard-card-three equal-size-body">
                            <div class="card-body msg-text">
                                <h4>Students of <b>Class:</b> {{ $data->section->class->class_number}}
                                    <b>Section:</b> {{ $data->section->section_number }} <br>
                                <b>Message: </b> <p></p>
                                <a href="" target="_blank">Class link</a>
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <th>{{ __('text.Date') }}</th>
                                        <th>{{ __('text.total_sms') }}</th>
                                    </thead>
                                    <tbody>
                                    @foreach($data->classSummary as $item)
                                        <tr>
                                            <td>{{ new_time_date_format($item->created_at) }}</td>
                                            <td>{{ $item->total_sms }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            @else
            <div class="card mt-5 false-height">
                <div class="card-body">
                    <div class="card-body-body mt-5 text-center">
                        {{ __('text.No_related_data_notification') }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

@endsection
@push('customjs')
    <script>

        var data = decodeURIComponent('<?php echo $data->message; ?>');
        var message = data.replace(/([+])/g, ' ');
        var urls = message.match(/\b(http|https)?(:\/\/)?(\S*)\.(\w{2,4})(.*)/g);

        $('.msg-text p').html(message);
        $('.msg-text a').attr('href', urls);

    </script>
@endpush
