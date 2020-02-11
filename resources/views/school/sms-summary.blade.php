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
            <li><a href="{{ route('all.school') }}">All School</a></li>
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
            <h3 class="border-bottom">{{ $school->name }}</h3>
            <form method="GET" action="">
                <div class="row mb-3">
                    <div class="form-group col-md-4">
                        <input type="text" name="from_date" value="{{ $from }}" data-date-format="yyyy-mm-dd" placeholder="From Date" class="form-control date" autocomplete="off" required>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" name="to_date" value="{{ $to }}" data-date-format="yyyy-mm-dd" placeholder="To Date" class="form-control date" autocomplete="off" required>
                    </div>
                    <div class="form-group col-md-2">
                        <button type="submit" class="button button--save font-weight-bold">Search</button>
                        <a href="{{Request::url().'?last_month=1'}}" class="button button--edit font-weight-bold ml-md-2">Last Month</a>
                        
                    </div>
                </div>
            </form>
            <table class="table table-bordered display text-wrap">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>To</th>
                    <th>Code</th>
                    <th>Class</th>
                    <th>SMS Type</th>
                </tr>
                </thead>
                <tbody>
                    @if( !$sms->isEmpty() )
                        @foreach ($sms as $item)
                            <tr>
                                <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                <td><a href="{{route('user.show',['user_code' => $item->user['student_code']]) }}">{{ $item->user['name'] }}</a></td>
                                <td>{{ $item->user['student_code'] }}</td>
                                <td>{{$item['user']['section']['class']['class_number']}} ({{ $item['user']['section']['section_number'] }})</td>
                                <td>{{ ucfirst($item->type) }}</td>
                            </tr>
                        @endforeach
                    @else 
                        <tr><td colspan="3" class="text-center">No data Found</td></tr>
                    @endif
                </tbody>
            </table>
            <div class="row mt-5">
                <div class="col-md-2 col-sm-12">
                    Showing {{ $sms->firstItem() ?? 0 }} to {{ $sms->lastItem() ?? 0 }} of {{ $sms->total() }}
                </div>
                <div class="col-md-10 col-sm-12 text-right">
                    <div class="paginate123 float-right">
                        {{ $sms->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
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

