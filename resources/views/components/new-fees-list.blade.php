<div class="table-responsive">
  <table class="table data-table text-nowrap">
    <thead>
    <tr>
      <th>#</th>
      <th>Fee Name</th>
      <th>Select</th>
    </tr>
    </thead>
    <tbody>
    @foreach($fees as $fee)
      <tr>
        <td>{{($loop->index + 1)}}</td>
        <td>{{$fee->fee_name}}</td>
        <td>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="{{$fee->fee_name}}" name="isSelected" aria-label="Select">
          </div>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>