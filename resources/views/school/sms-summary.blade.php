@extends('layouts.student-app')

@section('title', 'SMS Summary')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-envelope"></i>
            SMS Summary
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>SMS Summary</li>
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
            <form method="GET" action="">
                <div class="row border-bottom mb-3">
                    <div class="form-group col-md-4">
                        <input type="text" name="from_date" value="@if( isset($data['from_date']) ){{$data['from_date']}}@endif" data-date-format="yyyy-mm-dd" placeholder="From Date" class="form-control date" autocomplete="off" required>
                    </div>
                    <div class="form-group col-md-3">
                    <input type="text" name="to_date" value="@if( isset($data['to_date']) ){{$data['to_date']}}@endif" data-date-format="yyyy-mm-dd" placeholder="To Date" class="form-control date" autocomplete="off" required>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="submit" class="form-control form-control-sm btn bg-primary text-white" value="Search">
                    </div>
                </div>
            </form>
            
            @if(!empty($data))
                <table class="table table-bordered display text-wrap">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Total SMS</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($data['from_date'])->format('d M Y').' To '.\Carbon\Carbon::parse($data['to_date'])->format('d M Y') }}</td>
                            <td>{{ $data['totalSms'] }}</td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
    </div>
        
@endsection

@push('customjs')
<script>
    function alertDialog(formId) {
        swal({
            title: "Are you Sure",
            text: "Once deleted, you will not be able to recover this shift!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: {
                cancel: false,
                confirm: true,
            },
        })
        .then((willDelete) => {
            if (willDelete) {
                document.getElementById('delete-shift-'+formId).submit();
            }
        });
    }
</script>
@endpush

