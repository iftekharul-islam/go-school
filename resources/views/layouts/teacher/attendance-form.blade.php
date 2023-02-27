@if ($attendances > 0)
    <div class="text-center mt-5">
        <p>{{ __('text.attendance_notification') }}</p>
    </div>
@else
<form id="attendance-form" action="{{url('teacher/attendance/take-attendance')}}" method="post">
    {{ csrf_field() }}
    <input type="text" name="section_id" value="{{$section_id}}" style="display: none;">
    <input type="hidden" name="exam_id" value="{{$exam_id}}">
    <input type="hidden" name="update" value="0">
    <input type="hidden" name="attendances[]" value="0">
    <div class="table-responsive">
        <table class="table display table-bordered table-data-div text-nowrap">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ __('text.Code') }}</th>
                <th>{{ __('text.Name') }}</th>
                <th>{{ trans_choice('text.Present',1) }}
                    <button type="button" id="over-ride" class="button button--primary badge btn-override" data-purpose="over" onclick="activeAttendance();">Over ride</button>
                </th>
                <th>{{ __('text.Total Attended') }}</th>
                <th>{{ __('text.Total Missed') }}</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <input type="text" class="d-none" name="students[]" value="{{$student->id}}">
                    <tr>
                        <th scope="row">{{($loop->index + 1)}}</th>
                        <td>{{$student->student_code}}</td>
                        <td>
                            <span class="badge badge-danger attdState">{{ __('text.Absent') }}</span>&nbsp;&nbsp;
                            <a href="{{route('user.show', $student->student_code)}}">{{$student->name}}</a>
                        </td>
                        <td class="attendance-bar">
                            <div class="form-check ">
                                <input class="form-check-input formCheck" type="checkbox" name="isPresent{{$loop->index}}" aria-label="present" disabled="disabled">
                                <label for="">&nbsp;</label>
                            </div>
                        </td>
                        @if(count($attCount) > 0)
                            @php $is_available = false; @endphp
                            @foreach ($attCount as $at)
                                @if($at->student_id === $student->id)
                                    @php $is_available = true; @endphp
                                    <td>{{$at->totalpresent ?? 0 }}</td>
                                    <td>{{$at->totalabsent ?? 0 }}</td>
                                    @break
                                @endif
                            @endforeach
                            @if (!$is_available)
                                <td>0</td>
                                <td>0</td>
                            @endif
                        @else
                            <td>0</td>
                            <td>0</td>
                        @endif

                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="attendance mt-5">
            <button type="submit" class="button button--save float-right mb-5 updatebtn" disabled="disabled"><i class="far fa-save mr-2"></i>{{ __('text.Submit') }}</button>
        </div>
    </div>
</form>
@endif

