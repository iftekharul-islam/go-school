@extends('layouts.student-app')
@section('title', 'Fee Master')
@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>Dashboard</h3>
            <ul>
                <li>
                    <a href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">Home</a>
                </li>
                <li>Fee Master</li>
            </ul>
        </div>
        <div class="card height-auto false-height">
            <div class="card-body">
                <div class="heading-layout1">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="item-title">
                        <h3 class="float-left mb-5">Fee Master</h3>
                        <a href="{{ route('fee-master.create') }}" class="button button--save float-right">Add Fee Master</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table display text-wrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Class</th>
                            <th>Fee Name</th>
                            <th>Amount</th>
                            <th>Due Date</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($feeMasters as $feeMaster)
                            <tr>
                                <td>{{ $loop->index }}</td>
                                <td>{{ $feeMaster->myclass->class_number }}</td>
                                <td>{{ $feeMaster->feeType->name }}</td>
                                <td>{{ $feeMaster->amount }}</td>
                                <td>{{ $feeMaster->due }}</td>
                                <td>{{ $feeMaster->format }}</td>
                                <td>
                                    <a href="{{ route('fee-master.edit', $feeMaster->id) }}" class="button button--save mr-3"><i class="far fa-edit"></i></a>
                                    <button class="button button--cancel" onclick="feeMaster({{ $feeMaster->id }})"><i class="far fa-trash-alt"></i></button>
                                    <form id="delete-form-{{ $feeMaster->id }}" action="{{ route('fee-master.destroy', $feeMaster->id) }}" method="POST">
                                        {!! method_field('delete') !!}
                                        {!! csrf_field() !!}
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('customjs')
    <script type="text/javascript">
        function feeMaster(id) {
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        document.getElementById('delete-form-'+id).submit();
                        setTimeout(5000);
                        swal("Done! Your Selected file has been deleted!", {
                            icon: "success",
                        });
                    }
                });
        }
    </script>
@endpush