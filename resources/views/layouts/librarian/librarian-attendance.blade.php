@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{url('admin/staff/attendance/store')}}" method="post">
    {{ csrf_field() }}
    <div class="table-responsive">
        <table class="table display table-bordered table-data-div text-nowrap">
            <thead>
            <tr>
                <th>#</th>
                <th>Staff ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Present</th>
                <th>Total Attended</th>
                <th>Total Missed</th>
                <th>Adjust Missed Attendance</th>
            </tr>
            </thead>
            <tbody>
            @if (count($attendances) > 0)
                <input type="text" name="update" value="1" style="display: none;">

                @foreach ($librarians as $librarian)
                    <input type="text" name="staffs[]" value="{{$librarian->id}}" style="display: none;">
                @endforeach
                @foreach ($attendances as $attendance)
                    <tr>
                        <th scope="row">{{($loop->index + 1)}}</th>
                        <td>{{$attendance->stuff->student_code}}</td>
                        <td>
                            @if($attendance->present === 1)
                                <span class="badge-primary badge">Present</span>
                            @else
                                <span class="badge-danger badge">Absent</span>
                            @endif
                            &nbsp;&nbsp;<a href="{{url('user/'.$attendance->stuff->student_code)}}">{{$attendance->stuff->name}}</a>
                        </td>
                        <td>{{ ucfirst($attendance->role) }}</td>
                        <td>
                            <input type="text" name="attendances[]" value="{{$attendance->id}}" style="display: none;">
                            @if($attendance->present === 1)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" aria-label="Present" name="isPresent{{$loop->index}}" checked>
                                    <label for="">&nbsp;</label>
                                </div>
                            @else
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="isPresent{{$loop->index}}" aria-label="Absent">
                                    <label for="">&nbsp;</label>
                                </div>
                            @endif
                        </td>
                        @if(count($attCount) > 0)
                            @foreach ($attCount as $at)
                                @if($at->stuff_id == $attendance->stuff_id)
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
                        <td><a href="{{url('admin/staff/attendance/adjust/'.$attendance->stuff->id)}}" role="button" class="btn-link text-teal">Adjust Missing Attendances</a></td>
                    </tr>
                @endforeach
            @else
                <input type="number" name="update" value="0" style="display: none;">
                <input type="text" name="attendances[]" value="0" style="display: none;">
                @foreach ($librarians as $librarian)
                    <input type="text" name="staffs[]" value="{{$librarian->id}}" style="display: none;">
                    <tr>
                        <th scope="row">{{($loop->index + 1)}}</th>
                        <td>{{$librarian->student_code}}</td>
                        <td><span class="badge badge-primary attdState">Present</span>&nbsp;&nbsp;{{ $librarian->name }}</td>
                        <td>{{ ucfirst($librarian->role) }}</td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="isPresent{{$loop->index}}" aria-label="Present" checked>
                                <label for="">&nbsp;</label>
                            </div>
                        </td>
                        @if(count($attCount) > 0)
                            @foreach ($attCount as $at)
                                @if($at->stuff_id == $librarian->id)
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
                        @if(\Illuminate\Support\Facades\Auth::user()->role === 'admin')
                            <td><a href="{{url('admin/staff/teacher-attendance/adjust/'.$librarian->id)}}" role="button" class="btn-link text-teal">Adjust Missing Attendances</a></td>
                        @endif
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <div class="float-right mb-4">
        <a href="javascript:history.back()" class="button button--cancel mr-3" role="button"><i class="fas fa-window-close mr-2"></i>Cancel</a>
        @if (count($attendances) > 0)
            <button type="submit" class="button button--save"><i class="far fa-save mr-2"></i>Update</button>
        @else
            <button type="submit" class="button button--save"><i class="far fa-save mr-2"></i>Submit</button>
        @endif
    </div>
</form>
<script>
    $('input[type="checkbox"]').change(function () {
        var attdState = $(this).parent().parent().parent().find('.attdState').removeClass('badge-danger badge-primary');
        if ($(this).is(':checked')) {
            attdState.addClass('badge-primary').text('Present');
        } else {
            attdState.addClass('badge-danger').text('Absent');
        }
    });
</script>