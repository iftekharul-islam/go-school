@extends('layouts.student-app')

@section('title', 'Shifts')

@section('content')
    <div class="breadcrumbs-area">
        <h3>
            <i class="fas fa-clock"></i>
            {{ __('text.all_shift') }}
        </h3>
        <ul>
            <li><a href="{{ URL::previous() }}" style="color: #32998f!important;">
                    {{ __('text.Back') }} &nbsp;&nbsp;|</a>
                <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
            </li>
            <li>{{ __('text.shift') }}</li>
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
            @if ( count($shifts) > 0 )
                <table class="table table-bordered display text-wrap">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th>{{ __('text.shift') }}</th>
                        <th>{{ __('text.last_attendance') }}</th>
                        <th>{{ __('text.Exit Time') }}</th>
                        <th>{{ __('text.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($shifts as $key => $shift)
                        <tr>
                            <th scope="row">{{ $key +1 }}</th>
                            <td>{{ $shift->shift }}</td>
                            <td>{{ \Carbon\Carbon::parse($shift->last_attendance_time)->format('g:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($shift->exit_time)->format('g:i A') }}</td>
                            <td>
                                <a class="btn btn-lg btn-primary mr-3" href="{{route('shift.edit',['id' => $shift->id])}}"><i class="far fa-edit"></i></a>
                                <button class="btn btn-lg btn-danger mr-3" onclick="alertDialog({{ $shift->id }})"><i class="far fa-trash-alt"></i></button>
                                <form id="delete-shift-{{$shift->id}}" action="{{route('shift.delete',['id' =>$shift->id ])}}" method="post" class="d-none">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="paginate123 mt-5 float-right">
                    {{ $shifts->appends(request()->query())->links() }}
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

