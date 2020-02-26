@extends('layouts.student-app')
@section('title', 'Fee Master')
@section('content')
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/chosen/1.1.0/chosen.min.css">
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Create Fee Master</h3>
            <ul>
                <li>
                    <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
                </li>
                <li>Manage Accounts</li>
                <li><a href="{{  url(auth()->user()->role.'/fee-master') }}">Fee Master</a></li>
                <li>Add Fee Master </li>
            </ul>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                <div class="card false-height">
                    <div class="card-body">
                       <form class="mg-b-20" action="{{ url(auth()->user()->role.'/fee-master') }}" method="post">
                            {{ csrf_field() }}
                            <div class='row'>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="name">Class</label>
                                    <select name="class_id" id="" class="select2" onchange="generateFeeTypeField()" required>
                                        <option value="" selected>Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">Class - {{ $class->class_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="name">Recurrent Fee </label>
                                    <input type="checkbox" name="recurrent" id="recurrent" class="d-block" onchange="generateFeeTypeField()" />
                                </div>
                            </div>
                            <div class="col-md-12 d-none" id="typesTable">
                                <div class="table-responsive form-group" >
                                    <table class="table table-hover" id="feesTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Class</th>
                                                <th>Amount</th>
                                                <th>Due Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Class Name</td>
                                                <td><input type="number" step="0.01" placeholder="Fee Amount" class="form-control" name="amount" ></td>
                                                <td><input type="text" data-date-format="yyyy-mm-dd" id="due_date" class="form-control date" name="dueDate"  placeholder="Payment Due Date" autocomplete="off"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group mr-4 float-right mt-3">
                                    <button type="submit" role="button" class="button button--save">Create</button>
                                </div>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customjs')
<script>
    function generateFeeTypeField(){
        let feeTypes = {!! json_encode($feeTypes->toArray()) !!};
       
        if (feeTypes.length > 0) {
            let fields;
            if (!$('#recurrent').prop('checked')) {
                feeTypes.forEach((fee, index) => {
                    fields += '<tr>'
                                +'<td>'+(index+1)+'</td>'
                                +'<td>'+fee.name+'</td>'
                                +'<td>'
                                    +'<input type="number" placeholder="Fee Amount" class="form-control" name="amount[]" required>'
                                    +'<input type="hidden" name="fee_type[]" value="'+fee.id+'">'
                                +'</td>'
                                +'<td><input type="text" data-date-format="yyyy-mm-dd" class="form-control date" name="dueDate[]"  placeholder="Payment Due Date" autocomplete="off" required></td>'
                                +'<td><button type="button" class="button button--cancel delete-row"><i class="fas fa-trash"></i></button></td>'
                            +'</tr>';
                });
            } else {
                fields += '<tr>'
                                +'<td>1</td>'
                                +'<td>Monthly</td>'
                                +'<td>'
                                    +'<input type="number" placeholder="Fee Amount" class="form-control" name="amount" required>'
                                    +'<input type="hidden" name="fee_type" value="recurrent">'
                                +'</td>'
                                +'<td><input type="text" data-date-format="yyyy-mm-dd" class="form-control date" name="dueDate"  placeholder="Payment Due Date" autocomplete="off" required></td>'
                            +'</tr>';
            }
            $('#feesTable tbody').empty();
            $('#feesTable tbody').html(fields);
            $('#typesTable').removeClass('d-none').show('slow');
            reInitiateDatepicker();
        } else {
            warn();
        }
    }

    function warn(){
        swal({
            title: "Warning!",
            text: "Please create class before creating fee master!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
    }
    
    function reInitiateDatepicker(){
        $(".date").datepicker("destroy");
        $(".date").datepicker();
    }

   $(document).on('click', '.delete-row', function(){
       $(this).closest('tr').remove();
   });
   
</script>
@endpush
