@if(count($attendances) > 0)
<div class="col-md-12">=
    <form action="{{url(\Illuminate\Support\Facades\Auth::user()->role.'/attendance/adjust')}}" method="POST">
        {{ csrf_field() }}
        <table class="table display table-bordered data-table text-nowrap mb-5">
            <tr>
                <th>Present</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
            @foreach ($attendances as $att)
                <input type="hidden" name="att_id[]" value="{{$att->id}}">
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="isPresent[]" aria-label="Present" checked="">
                            <label for="">&nbsp;</label></div>
                    </td>
                    <td>
                        @if($att->present === 0)
                            <span class="label label-danger attdState">Absent</span>
                         @else
                            <span class="label label-warning attdState">Escaped</span>
                        @endif
                    </td>
                    <td>{{$att->created_at->format('m/d/Y')}}</td>
                </tr>
            @endforeach
        </table>
        <a href="javascript:history.back()" class="button button--cancel" style="margin-right: 2%;" role="button">Cancel</a>
        <input type="submit" class="button button--save" value="Submit"/>
    </form>
</div>
<script>
  $('input[type="checkbox"]').change(function() {
      var attdState = $(this).parent().parent().parent().find('.attdState').removeClass('label-danger label-success');
      if($(this).is(':checked')){
        attdState.addClass('label-success').text('Present');
      } else {
        attdState.addClass('label-danger').text('Absent');
      }
  });
</script>
@endif
