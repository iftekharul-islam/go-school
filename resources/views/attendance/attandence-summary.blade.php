@extends('layouts.student-app')

@section('title', 'Attendance')

@section('content')

    <div class="card mt-5 false-height">
        <div class="card-body">
            <div class="card-body-body mt-5 text-center">
                <h1>Student Attendance Summary</h1>
                <div class="table-responsive">
                    <table class="table table-bordered ">
                    <thead>
                    <tr>
                        <th>Name</th>
                        @php
                            $begin = new DateTime($start_date);
                            $end = new DateTime($end_date);

                            $interval = DateInterval::createFromDateString('1 day');
                            $period = new DatePeriod($begin, $interval, $end);
                        @endphp
                        @foreach ($period as $dt)
                            <th>{{ $dt->format("d") }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($final as $student)
                        <tr>
                            <td class="text-nowrap text-left"> {{ $student['name'] }} </td>
                                @foreach ($student['attendances'] as $item)
                                @if ($item >= 0)
                                    <td class="px-5">
                                        @if ($item == '0')
                                            <i class="fa fa-circle text-info"></i>
                                        @elseif($item == '1')
                                            <i class="fa fa-check text-success"></i>
                                        @elseif($item == '2')
                                            <i class="fa fa-plane text-warning"></i>
                                        @elseif($item == null)
                                            <i class="fa fa-times text-danger"></i>
                                        @endif
                                    </td>
                                @else
                                    <td></td>
                                @endif

                                @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

@endsection
