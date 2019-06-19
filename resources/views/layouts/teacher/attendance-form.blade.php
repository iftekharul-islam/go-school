@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{url('attendance/take-attendance')}}" method="post">
    {{ csrf_field() }}
    <input type="text" name="section_id" value="{{$section_id}}" style="display: none;">
    <input type="hidden" name="exam_id" value="{{$exam_id}}">
    <div class="table-responsive">
        <table class="table display table-data-div text-nowrap">
            <thead>
            <tr>
                <th>#</th>
                <th>Student_Code</th>
                <th>Name</th>
                <th>Present</th>
                <th>Total Attended</th>
                <th>Total Missed</th>
                <th>Total Escaped</th>
                <th>Adjust Missed Attendance</th>
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
                                <span class="badge-primary badge">Present</span>
                            @elseif($attendance->present === 2)
                                <span class="badge-warning badge">Escaped</span>
                            @else
                                <span class="badge-danger badge">Absent</span>
                            @endif
                            <a href="{{url('user/'.$attendance->student->student_code)}}">{{$attendance->student->name}}</a>
                        </td>
                        <td>
                            <input type="text" name="attendances[]" value="{{$attendance->id}}" style="display: none;">
                            @if($attendance->present === 1)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" aria-label="Present" name="isPresent{{$loop->index}}" checked>
                                </div>
                            @else
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="isPresent{{$loop->index}}" aria-label="Absent">
                                </div>
                            @endif
                        </td>
                        @if(count($attCount) > 0)
                            @foreach ($attCount as $at)
                                @if($at->student_id == $attendance->student->id)
                                    <td>{{$at->totalpresent}}</td>
                                    <td>{{$at->totalabsent}}</td>
                                    <td>{{$at->totalescaped}}</td>
                                @else
                                    @continue
                                @endif
                            @endforeach
                        @else
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        @endif
                        <td><a href="{{url('attendance/adjust/'.$attendance->student->id)}}" role="button" class="btn btn-danger btn-lg">Adjust Missing Attendances</a></td>
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
                        <td><span class="badge badge-success attdState">Present</span>{{$student->name}}</td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="isPresent{{$loop->index}}" aria-label="Present" checked>
                                <label for="">&nbsp;</label>
                            </div>
                        </td>
                        @if(count($attCount) > 0)
                            @foreach ($attCount as $at)
                                @if($at->student_id == $student->id)
                                    <td>{{$at->totalpresent}}</td>
                                    <td>{{$at->totalabsent}}</td>
                                    <td>{{$at->totalescaped}}</td>
                                @else
                                    @continue
                                @endif
                            @endforeach
                        @else
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        @endif
                        <td><a href="{{url('attendance/adjust/'.$student->id)}}" role="button" class="btn btn-primary btn-lg">Adjust Missing Attendances</a></td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <div style="text-align:center;">
{{--        <a href="javascript:history.back()" class="btn btn-danger btn-lg mr-3" role="button">Cancel</a>--}}
        @if (count($attendances) > 0)
{{--            <button type="submit" class="btn btn-primary mr-3 btn-lg">Update</button>--}}
        @else
            <button type="submit" class="btn btn-primary mr-3 btn-lg">Submit</button>
        @endif
    </div>
</form>
<script>
    $('input[type="checkbox"]').change(function () {
        var attdState = $(this).parent().parent().parent().find('.attdState').removeClass('badge-danger badge-success');
        if ($(this).is(':checked')) {
            attdState.addClass('badge-success').text('Present');
        } else {
            attdState.addClass('badge-danger').text('Absent');
        }
    });
</script>