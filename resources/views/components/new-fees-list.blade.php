 <div class="table-responsive">
      <table class="table display table-data-div text-nowrap">
        <thead>
        <tr>
          <th>#</th>
          <th>Fee Name</th>
          <th>Select</th>
        </tr>
        </thead>
        <tbody>
          @foreach($fees as $key => $fee)
            <tr>
              <td>{{($loop->index + 1)}}</td>
              <td>{{$fee->fee_name}}</td>
              <td>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input">
                  <label class="form-check-label">&nbsp;</label>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>