@extends('layouts.student-app')

@section('title', 'Payment Details')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-file-invoice"></i>
            Generate Invoice
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    Back &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
            </li>
            <li>Generate Invoice</li>
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
            <form method='POST' action="{{route('send.invoice')}}">
                {{ csrf_field() }}
                <div class="row border-bottom mb-3">
                    <div class="form-group col-md-3">
                        <select name="month" id="section_id" class="form-control form-control-sm select2" required>
                            <option value="" disabled selected >Select Month</option>
                            <option value="1" @if(old('month') == 1) selected @endif>January</option>
                            <option value="2" @if(old('month') == 2) selected @endif>February</option>
                            <option value="3" @if(old('month') == 3) selected @endif>March</option>
                            <option value="4" @if(old('month') == 4) selected @endif>April</option>
                            <option value="5" @if(old('month') == 5) selected @endif>May</option>
                            <option value="6" @if(old('month') == 6) selected @endif>June</option>
                            <option value="7" @if(old('month') == 7) selected @endif>July</option>
                            <option value="8" @if(old('month') == 8) selected @endif>August</option>
                            <option value="9" @if(old('month') == 9) selected @endif>September</option>
                            <option value="10" @if(old('month') == 10) selected @endif>October</option>
                            <option value="11" @if(old('month') == 11) selected @endif>Novenber</option>
                            <option value="12" @if(old('month') == 12) selected @endif>December</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="submit" class="form-control form-control-sm btn bg-primary text-white" value="Generate" />
                    </div>
                </div>
            </form>
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

