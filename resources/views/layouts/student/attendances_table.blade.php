<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css"/>

<style>
    .fc-agendaWeek-button {
        display: none;
    }

    .fc-agendaDay-button {
        display: none;
    }

    .fc-month-button {
        display: none;
    }
</style>
<div class="row information">
    <div class="col-6 col-lg-3 col-xs-6 col-sm-6">
        <div class="dashboard-summery-two">
            <div class="item-icon bg-light-blue-transparent">
                <i class="fas fa-building text-light"></i>
            </div>
            <div class="item-content">
                <div class="item-number"><span class="counter" data-num="{{ $total }}"></span></div>
                @isset($user_type)
                    <div class="item-title">{{ __('text.total_work_day') }}</div>
                @else
                    <div class="item-title">{{ __('text.Total Classes') }}</div>
                @endisset
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 col-sm-6 col-xs-6">
        <div class="dashboard-summery-two">
            <div class="item-icon bg-light-teal-transparent">
                <i class="fas fa-clipboard-check text-light"></i>
            </div>
            <div class="item-content">
                <div class="item-number"><span class="counter" data-num="{{ $present }}"></span></div>
                <div class="item-title"><a href="{{ route('attendees', request('user_id')) }}">{{ __('text.Total Attended') }}</a></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 col-sm-6 col-xs-6">
        <div class="dashboard-summery-two">
            <div class="item-icon bg-light-red-transparent">
                <i class="far fa-times-circle text-light"></i>
            </div>
            <div class="item-content">
                <div class="item-number"><span class="counter" data-num="{{ $absent }}"></span></div>
                <div class="item-title"><a href="{{ route('absents', request('user_id')) }}">{{ __('text.Total Missed') }}</a></div>
            </div>
        </div>
    </div>
    @isset($escaped)
        <div class="col-lg-3 col-sm-6 col-6">
            <div class="dashboard-summery-two">
                <div class="item-icon bg-light-yellow-transparent">
                    <i class="fas fa-sign-out-alt text-light"></i>
                </div>
                <div class="item-content">
                    <div class="item-number"><span class="counter" data-num="{{ $escaped }}"></span></div>
                    <div class="item-title">{{ __('text.Total Attended') }}</div>
                </div>
            </div>
        </div>
    @endisset
</div>
<div class="card">
    <div class="card-body false-height">
        <div class="col-md-12 col-sm-12 col-lg-12  text-capitalize ">
            <h5>{{ __('text.list_of_total_attendance') }}</h5>
            {!! $calendar->calendar() !!}
        </div>
    </div>
</div>
{!! $calendar->script() !!}
