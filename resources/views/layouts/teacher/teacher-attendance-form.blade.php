@if ($attendances > 0)
    <div class="text-center mt-5">
        <p>{{ __('text.attendance_notification') }}</p>
    </div>
@else
<form action="{{url('admin/staff/attendance/store')}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="update" value="0">
    <input type="hidden" name="attendances[]" value="0">
    <div class="table-responsive">
        <table class="table display table-bordered table-data-div text-nowrap">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ __('text.Staff ID') }}</th>
                <th>{{ __('text.Name') }}</th>
                <th>{{ __('text.Role') }}</th>
                <th>{{ trans_choice('text.Present',1) }}</th>
                <th>{{ __('text.Total Attended') }}</th>
                <th>{{ __('text.Total Missed') }}</th>
                <th>{{ __('text.Adjust Attendance') }}</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($staffs as $staff)
                    <input type="text" class="d-none" name="staffs[]" value="{{$staff->id}}">
                    <tr>
                        <th scope="row">{{($loop->index + 1)}}</th>
                        <td>{{$staff->student_code}}</td>
                        <td><span class="badge badge-primary attdState">{{ trans_choice('text.Present',2) }}</span>&nbsp;&nbsp;{{ $staff->name }}
                        </td>
                        <td>{{ ucfirst($staff->role) }}</td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="isPresent{{$loop->index}}"
                                       aria-label="Present" checked>
                                <label for="">&nbsp;</label>
                            </div>
                        </td>
                        @if(count($attCount) > 0)
                            @php $is_available = false; @endphp
                            @foreach ($attCount as $at)
                                @if($at->stuff_id == $staff->id)
                                    @php $is_available = true; @endphp
                                    <td>{{$at->totalpresent ?? 0}}</td>
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
                        @if(current_user()->role === 'admin')
                            <td><a href="{{url('admin/staff/teacher-attendance/adjust/'.$staff->id)}}" role="button"
                                   class="btn-link text-teal">{{ __('text.Adjust Missed Attendance') }}</a></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="float-right mb-4">
        <button type="submit" class="button button--save"><i class="far fa-save mr-2"></i>{{ __('text.Submit') }}</button>
    </div>
</form>
@endif
<script>
    $('input[type="checkbox"]').change(function () {
        var attdState = $(this).parent().parent().parent().find('.attdState').removeClass('badge-danger badge-primary');
        if ($(this).is(':checked')) {
            attdState.addClass('badge-primary').text('{{ trans_choice('text.Present',2) }}');
        } else {
            attdState.addClass('badge-danger').text('{{ __('text.Absent') }}');
        }
    });
</script>
