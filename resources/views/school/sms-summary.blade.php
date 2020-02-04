@extends('layouts.student-app')

@section('title', 'SMS Summary')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-clock"></i>
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
                    <input type="date" name="from_date" value="" class="form-control form-control-sm" required>
                </div>
                <div class="form-group col-md-3">
                  <input type="date" name="to_date" value="" class="form-control form-control-sm" required>
                </div>
                <div class="form-group col-md-2">
                    <input type="submit" class="form-control form-control-sm btn bg-primary text-white" value="Search">
                </div>
            </div>
            </form>
            <table class="table table-bordered display text-wrap">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
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

