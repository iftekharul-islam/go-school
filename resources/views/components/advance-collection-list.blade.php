<div class="breadcrumbs-area">
    <h3><i class="fas fa-hand-holding-usd "></i> {{ __('text.advance_collection') }}</h3>
    <ul>
        <li>
            <a href="{{ URL::previous() }}" style="color: #32998f!important;">{{ __('text.Back') }} &nbsp;|</a>
            <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;{{ __('text.Home') }}</a>
        </li>
        <li> {{ __('text.advance_collection') }} </li>
    </ul>
</div>
 @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
 @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="card height-auto">
    <div class="card-body">

        <form id="filter" method='GET' action="">
        <div class="row mb-3">
            <div class="form-group col-md-5">
                <input type="text" name="student_name" value="{{$searchData['student_name']}}" class="form-control form-control-sm" placeholder="{{ __('text.Name') }}" />
            </div>
            <div class="form-group col-md-2">
                <select id="class_id" name="class_id" onchange="getSections(this)" class="form-control form-control-sm">
                    <option value="" selected>{{ __('text.Class') }}</option>
                    @foreach ($classes as $class)
                        <option value="{{$class->id}}" @if($class->id == $searchData['class_id']) selected @endif>{{$class->class_number}}</option>    
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-2">
                <select name="section_id" id="section_id" class="form-control form-control-sm">
                    @if($searchData['class_id'])
                        @if($classes)
                            @foreach ($classes as $class)
                                @if($class->id == $searchData['class_id'])
                                    @if($class->sections)
                                        @foreach ( $class->sections as $section)
                                            <option value="{{$section['id']}}" @if($searchData['section_id'] == $section['id']) selected @endif>{{$section['section_number']}}</option>
                                        @endforeach
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    @else 
                        <option value="" disabled selected >{{ __('text.Section') }}</option>
                    @endif
                </select>
            </div>
            <div class="form-group col-md-3">
                <button type="submit" class="button button--save font-weight-bold">{{ __('text.Search') }}</button>
                <button type="button" onclick="resetFilter()" class="button button--cancel font-weight-bold ml-md-3">{{ __('text.reset') }}</button>
            </div>
        </div>
        </form>

        
         @if(count($students) > 0)

            <div class="mb-5">
                <table class="table table-bordered display text-wrap">
                    <thead>
                    <tr>
                        <th>{{ __('text.Code') }}</th>
                        <th>{{ __('text.Name') }}</th>
                        <th>{{ __('text.roll_number') }}</th>
                        <th>{{ __('text.session') }}</th>
                        <th>{{ __('text.Class') }}</th>
                        <th>{{ __('text.Section') }}</th>
                        <th>{{ __('text.amount') }}</th>
                        <th>{{ __('text.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($students as $key => $student)
                        <tr>
                            <td>{{$student->student_code}}</td>
                            <td>
                                <a class="text-teal" href="{{url('user/'.$student->student_code)}}">{{ $student->name }}</a>
                            </td>
                            <td>{{ $student->studentInfo['roll_number'] }}</td>
                            <td>{{ $student->studentInfo['session'] }}</td>
                            <td>{{ $student->section['class']['class_number'] }} {{ !empty($student->group)? '- '.$student->group:' '}}</td>
                            <td style="white-space: nowrap;">{{ $student->section['section_number'] }}</td>
                            <td> {{ number_format($student->studentInfo['advance_amount'], 2) }}</td>
                            <td>
                                <a class="btn btn-lg btn-secondary mr-3 open-modal" data-id="{{$student->student_code}}" data-current-amount="{{$student['studentInfo']['advance_amount']}}" data-name="{{$student->name}}" href="#" data-toggle="modal" data-target="#updateAmount" title="Update Advance Amount"><i class="far fa-edit"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row mt-5">
                    <div class="col-md-3 col-sm-12">
                        Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }}
                    </div>
                    <div class="col-md-9 col-sm-12 text-right">
                        <div class="paginate123 float-right">
                            {{ $students->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
                
            </div>

         @else
            <p class="text-center">No Student Found.</p>
        @endif
    </div>
</div>

<div class="modal fade" id="updateAmount" role="dialog" aria-labelledby="updateAmount">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Advance Balance</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form id ="form_update_amount" class="new-added-form" action="{{ url(auth()->user()->role.'/update-advance-collection') }}" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="col-sm-12 control-label" id="stdName">Enter Amount</label>
                        <div class="col-sm-12 text-center">
                            <input type="hidden" name="student_code" value="">
                            <input type="number" name="advanceAmount"  class="form-control" id="advanceAmount" placeholder="Enter Amount" required>
                        </div>
                    </div>
                </div>
                <div class="form-group modal-footer pb-">
                    <div class="col-md-12">
                        <button type="submit" class="button button--save float-right">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('customjs')
    <script type="text/javascript">
        jQuery(document).ready(function() {
            $('.open-modal').click(function() {
               $('#form_update_amount input[name=student_code]').val($(this).data('id'));
               $('#form_update_amount #stdName').text($(this).data('name'));
               $('#form_update_amount input[name=advanceAmount]').val($(this).data('current-amount'));
            });
        });

        function getSections(item) {
            let selectedClass = item.value;
            if(selectedClass != ''){
                let classes = {!! json_encode($classes->toArray()) !!};
                let sections = [];
                classes.forEach((cls) => {
                    if (cls.id == selectedClass) {
                        sections = cls.sections;
                    }
                });
                $('#section_id').empty();
                sections.forEach((sec) => {
                    $('#section_id').append($("<option />").val(sec.id).text(sec.section_number));
                });
            }
        }

        function submitForm(formId) {
            swal({
                title: "Are you sure?",
                text: " You want to perform this action!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.getElementById(formId).submit();
                }
            });
        }

        function showAlert() {
            swal({
                title: "No Student Selected",
                text: "Please select at least one student",
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
                    document.getElementById(formId).submit();
                }
            });
        }

        function resetFilter() {
            $('#filter input[name=student_name]').val('');
            $("#filter select").empty();
            $("#filter").submit();
        }
    </script>
@endpush
