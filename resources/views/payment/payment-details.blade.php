@extends('layouts.student-app')

@section('title', 'Payment Details')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-clock"></i>
            Payment Details
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Payment Details</li>
        </ul>
    </div>
     @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card height-auto mb-5">
        <div class="card-body">
            @if ( count($schoolMetas) > 0 )
                <table class="table table-bordered display text-wrap">
                    <thead>
                    <tr>
                        <th>School Name</th>
                        <th>SMS Charge</th>
                        <th>Per Student Charge</th>
                        <th>Invoicing Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($schoolMetas as $key => $schoolMeta)
                        <tr>
                            <td>{{ $schoolMeta['school']['name'] }}</td>
                            <td>{{ $schoolMeta['sms_charge'] }}</td>
                            <td>{{ $schoolMeta['per_student_charge'] }}</td>
                            <td>{{ $schoolMeta['invoice_generation_date'] }}</td>
                            <td>
                                <a class="btn btn-lg btn-primary mr-3" href="{{route('shift.edit',['id' => $schoolMeta->id])}}"><i class="far fa-edit"></i></a>
                                <button class="btn btn-lg btn-danger mr-3" onclick="alertDialog({{ $schoolMeta->id }})"><i class="far fa-trash-alt"></i></button>
                                <form id="delete-payment-{{$schoolMeta->id}}" action="{{route('delete.payment.info',['id' =>$schoolMeta->id ])}}" method="post" class="d-none">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="paginate123 mt-5 float-right">
                    {{ $schoolMetas->appends(request()->query())->links() }}
                </div>
            @else   
                <p class="text-center">No Data Found</p>
            @endif
        </div>
    </div>
        
@endsection

@push('customjs')
<script>
    function alertDialog(formId) {
        swal({
            title: "Are you Sure",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                document.getElementById('delete-payment-'+formId).submit();
            }
        });
    }
</script>
@endpush

