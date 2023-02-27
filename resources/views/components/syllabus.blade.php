@if(count($syllabuses) > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ __('text.file_name') }}</th>
                <th>{{ __('text.Class') }}</th>
                <th>{{ __('text.Action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($syllabuses as $index => $syllabus)
                <tr>
                    <td>{{ $index + $syllabuses->firstItem() }}</td>
                    <td>{{ $syllabus->title }}</td>
                    <td>{{ $syllabus['myclass']['class_number'] }}
                    <td>
                        <a class="text-teal" href="{{url($syllabus->file_path)}}" target="_blank" title="Download File">
                            <i class="fas fa-download"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="row mt-5">
            <div class="col-md-2 col-sm-12">
                Showing {{ $syllabuses->firstItem() }} to {{ $syllabuses->lastItem() }} of {{ $syllabuses->total() }}
            </div>
            <div class="col-md-10 col-sm-12 text-right">
                <div class="paginate123 float-right">
                    {{ $syllabuses->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
@else
    <div class="mt-5 false-height">
        <div class="card-body mt-5 text-center">
            {{ __('text.No_related_data_notification') }}
        </div>
    </div>
@endif
