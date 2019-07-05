<div class="table-responsive">
    <table class="table display data-table text-nowrap">
        <thead>
        <tr>
          <th>#</th>
          <th>Fee Name</th>
{{--          <th>Select</th>--}}
          <th>Remove</th>
        </tr>
        </thead>
        <tbody>
          @foreach($fees as $key => $fee)
            <tr>
              <td>{{($loop->index + 1)}}</td>
              <td>{{$fee->fee_name}}</td>
              <td>
                  <button class="btn btn-danger btn-lg" onclick="book()">Delete</button>
                  <a id="delete-form" href="{{ url('fees/remove', ['id' => $fee->id]) }}"></a>
              </td>
{{--              <td>--}}
{{--                <div class="form-check">--}}
{{--                  <input type="checkbox" class="form-check-input">--}}
{{--                  <label class="form-check-label">&nbsp;</label>--}}
{{--                </div>--}}
{{--              </td>--}}
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

 @push('customjs')
     <script type="text/javascript">
         function book() {
             swal({
                 title: "Are you sure?",
                 text: "Once deleted, you will not be able to recover this file!",
                 icon: "warning",
                 buttons: true,
                 dangerMode: true,
             })
                 .then((willDelete) => {
                     if (willDelete) {
                         document.getElementById('delete-form').click();
                         setTimeout(5000);
                         swal("Poof! Your Selected file has been deleted!", {
                             icon: "success",
                         });
                     }
                 });
         }
     </script>
 @endpush
