<div class="table-responsive">
    <table class="table display table-data-div text-nowrap">
        <thead>
        <tr>
          <th>#</th>
          <th>Fee Name</th>
          <th>Remove</th>
        </tr>
        </thead>
        <tbody>
          @foreach($fees as $key => $fee)
            <tr>
              <td>{{($loop->index + 1)}}</td>
              <td>{{$fee->fee_name}}</td>
              <td>
                  <button class="button button--cancel" onclick="removeFees({{ $fee->id }})">Delete</button>
                  <form id="delete-form-{{ $fee->id }}" action="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/fees/remove', ['id' => $fee->id]) }}" method="POST">
                      {!! method_field('delete') !!}
                      {!! csrf_field() !!}
                  </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

 @push('customjs')
     <script type="text/javascript">
         function removeFees(id) {
             swal({
                 title: "Are you sure?",
                 text: "Once deleted, you will not be able to recover this data!",
                 icon: "warning",
                 buttons: true,
                 dangerMode: true,
             })
                 .then((willDelete) => {
                     if (willDelete) {
                         document.getElementById('delete-form-'+id).submit();
                         setTimeout(5000);
                         swal("Poof! Your Selected data has been deleted!", {
                             icon: "success",
                         });
                     }
                 });
         }
     </script>
 @endpush
