@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form id="attendance-form" action="{{url('teacher/attendance/take-attendance')}}" method="post">
    {{ csrf_field() }}
    <input type="text" name="section_id" value="{{$section_id}}" style="display: none;">
    <input type="hidden" name="exam_id" value="{{$exam_id}}">
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
            @if (count($attendances) > 0)
                <input type="text" name="update" value="1" style="display: none;">

                @foreach ($students as $student)
                    <input type="text" name="students[]" value="{{$student->id}}" style="display: none;">
                @endforeach
                @foreach ($attendances as $attendance)
                    <tr>
                        <th scope="row">{{($loop->index + 1)}}</th>
                        <td>{{$attendance->student->student_code}}</td>
                        <td>
                            @if($attendance->present === 1)
                                <span class="badge-primary attdState badge">{{ trans_choice('text.Present',2) }}</span>
                            @else
                                <span class="badge-danger attdState badge">{{ __('text.Absent') }}</span>
                            @endif
                            &nbsp;&nbsp;<a href="{{url('user/'.$attendance->student->student_code)}}">{{$attendance->student->name}}</a>
                        </td>
                        <td class="attendance-bar">
                            <input type="text" name="attendances[]" value="{{$attendance->id}}" style="display: none;">
                            @if($attendance->present === 1)
                                <div class="form-check">
                                    <input class="form-check-input formCheck" type="checkbox" name="isPresent{{$loop->index}}" aria-label="Present" disabled="disabled" checked>
                                    <label for="">&nbsp;</label>
                                </div>
                            @else
                                <div class="form-check">
                                    <input class="form-check-input formCheck" type="checkbox" name="isPresent{{$loop->index}}" aria-label="Absent" disabled="disabled" >
                                    <label for="">&nbsp;</label>
                                </div>
                            @endif
                        </td>
                        @if(count($attCount) > 0)
                            @foreach ($attCount as $at)
                                @if($at->student_id == $attendance->student->id)
                                    <td>{{$at->totalpresent ? $at->totalpresent : 0}}</td>
                                    <td>{{$at->totalabsent ? $at->totalabsent : 0}}</td>
                                @else
                                    @continue
                                @endif
                            @endforeach
                        @else
                            <td>0</td>
                            <td>0</td>
                        @endif
                    </tr>
                @endforeach
            @else
                <input type="number" name="update" value="0" style="display: none;">
                <input type="text" name="attendances[]" value="0" style="display: none;">
                @foreach ($students as $student)
                    <input type="text" name="students[]" value="{{$student->id}}" style="display: none;">
                    <tr>
                        <th scope="row">{{($loop->index + 1)}}</th>
                        <td>{{$student->student_code}}</td>
                        <td><span class="badge badge-danger attdState">{{ __('text.Absent') }}</span>&nbsp;&nbsp;<a href="{{url('user/',$student->student_code)}}">{{$student->name}}</a></td>
                        <td class="attendance-bar">
                            <div class="form-check ">
                                <input class="form-check-input formCheck" type="checkbox" name="isPresent{{$loop->index}}" aria-label="present" disabled="disabled">
                                <label for="">&nbsp;</label>
                            </div>
                        </td>
                        @if(count($attCount) > 0)
                            @foreach ($attCount as $at)
                                @if($at->student_id == $student->id)
                                    <td>{{$at->totalpresent ? $at->totalpresent : 0}}</td>
                                    <td>{{$at->totalabsent ? $at->totalabsent: 0 }}</td>
                                @else
                                    <td>0</td>
                                    <td>0</td>
                                    @break
                                @endif
                            @endforeach
                        @else
                            <td>0</td>
                            <td>0</td>
                        @endif

                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <div class="attendance mt-5">
        @if (count($attendances) > 0)
            <button type="submit" class="button button--save float-right mb-5 updatebtn" disabled="disabled"><i class="far fa-save mr-2"></i>{{ __('text.Update') }}</button>
        @else
            <button type="submit" class="button button--save float-right mb-5 updatebtn" disabled="disabled"><i class="far fa-save mr-2"></i>{{ __('text.Submit') }}</button>
        @endif
    </div>
</form>

