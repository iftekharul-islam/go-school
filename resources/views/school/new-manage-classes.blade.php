@foreach($schools as $school)
    @if(\Auth::user()->role == 'master' || \Auth::user()->school_id == $school->id)
        @if(\Auth::user()->school_id == $school->id)
            <tr class="collapse" id="collapse{{($loop->index + 1)}}"
                aria-labelledby="heading{{($loop->index + 1)}}"
                aria-expanded="false">
                <td colspan="12">
                    @include('layouts.master.add-class-form')
                    <div>
                        <small>Click Class to View All Sections</small>
                    </div>
                    <div class="row">
                        @foreach($classes as $class)
                            @if($class->school_id == $school->id)
                                <div class="col-sm-3">
                                    <button type="button"
                                            class="button button--save btn-lg float-left"
                                            data-toggle="modal"
                                            data-target="#myModal{{$class->id}}"
                                            style="margin-top: 5%;">
                                        Manage Class
                                        : {{$class->class_number}} {{!empty($class->group)? '- '.$class->group:''}}</button>
                                    <!-- Modal -->
                                    <div class="modal fade"
                                         id="myModal{{$class->id}}"
                                         tabindex="-1" role="dialog"
                                         aria-labelledby="myModalLabel">
                                        <div class="modal-dialog modal-lg"
                                             role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title"
                                                        id="myModalLabel">
                                                        All
                                                        Sections of
                                                        Class {{$class->class_number}}</h4>
                                                    <button type="button"
                                                            class="close"
                                                            data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <ul class="list-group">
                                                        @foreach($sections as $section)
                                                            @if($section->class_id == $class->id)
                                                                <li class="list-group-item">
                                                                    Section {{$section->section_number}}
                                                                    &nbsp
                                                                    <a class="btn btn-lg btn-primary mr-2" id="edit-section-btn-{{$section->id}}"
                                                                        data-toggle="collapse" href="#collapseForEditSection{{$section->id}}"
                                                                        aria-expanded="false" aria-controls="collapseForEditSection{{$section->id}}">
                                                                        <i class="far fa-edit"></i> Edit
                                                                    </a>
                                                                    &nbsp
                                                                    <a class="btn btn-lg btn-warning mr-2"
                                                                       href="{{url('admin/courses/0/'.$section->id)}}">View
                                                                        All
                                                                        Assigned
                                                                        Courses</a>
                                                                    <span class="pull-right"> &nbsp;&nbsp
                                                                        <a class="btn btn-lg btn-success mr-2" href="{{url('admin/school/promote-students/'.$section->id)}}">+ Promote Students</a>
                                                                    </span>
                                                    
                                                                    @include('layouts.master.add-course-form')
                                                                    
                                                                    <div class="collapse" id="collapseForEditSection{{$section->id}}" style="margin-top:1%;">
                                                                        <div class="panel panel-default">
                                                                            <div class="panel-body">
                                                                                <form id="EditSectionForm{{$section->id}}" class="form-horizontal" action="{{route('edit.section', ['id' => $section->id])}}" method="post">
                                                                                    {{csrf_field()}}
                                                                                    <div class="false-padding-bottom-form form-group">
                                                                                        <label for="" class="col-sm-12 control-label false-padding-bottom">Section Number</label>
                                                                                        <div class="col-sm-12">
                                                                                            <input type="text" class="form-control" name="section_number" value="{{$section->section_number}}" required>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <div class="col-sm-12">
                                                                                            <button type="submit" class="button button--save float-right">Update Section</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>

                                                    @include('layouts.master.create-section-form')
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                            class="button button--cancel"
                                                            data-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </td>
            </tr>
        @endif
    @endif
@endforeach
