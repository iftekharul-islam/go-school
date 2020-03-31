@foreach($schools as $school)
    @if(\Auth::user()->role == 'master' || \Auth::user()->school_id == $school->id)
        @if(\Auth::user()->school_id == $school->id)
            <tr class="collapse" id="collapse{{($loop->index + 1)}}"
                aria-labelledby="heading{{($loop->index + 1)}}"
                aria-expanded="false">
                <td colspan="12">
                    @include('layouts.master.add-class-form')
                    <div>
                        <small>{{ __('text.click_class') }}</small>
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
                                        {{ __('text.manage_class') }}
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
                                                        {{ __('text.all_section') }} {{$class->class_number}} </h4>
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
                                                                    {{ __('text.Section') }} {{$section->section_number}}
                                                                    &nbsp
                                                                    <a class="btn btn-lg btn-warning mr-2"
                                                                       href="{{url('admin/courses/0/'.$section->id)}}">
                                                                        {{ __('text.view_course') }}</a>
                                                                    <span class=""> &nbsp;&nbsp
                                                                        <a class="btn btn-lg btn-success mr-2" href="{{url('admin/school/promote-students/'.$section->id)}}">+ {{ __('text.promote_students') }}</a>
                                                                    </span>
                                                                    &nbsp
                                                                    <a class="btn btn-lg btn-info pull-right mr-2" data-toggle="collapse" href="#collapseForNewCourse{{$section->id}}"
                                                                       aria-expanded="false" aria-controls="collapseForNewCourse{{$section->id}}">+ {{ __('text.add_course') }}</a>
                                                                    &nbsp
                                                                    <a class="btn btn-lg btn-primary mr-2" id="edit-section-btn-{{$section->id}}"
                                                                       data-toggle="collapse" href="#collapseForEditSection{{$section->id}}"
                                                                       aria-expanded="false" aria-controls="collapseForEditSection{{$section->id}}">
                                                                        <i class="far fa-edit"></i> {{ __('text.edit') }}
                                                                    </a>
                                                                    &nbsp
                                                                    <button class='btn btn-lg btn-danger mr-2' type="button" onclick="removeSection({{ $section->id }})"><i class="far fa-trash-alt mr-2"></i>{{ __('text.delete') }}</button>
                                                                    <form id="delete-form-{{ $section->id }}" action="{{ route('delete.section', $section->id) }}"
                                                                          method="post" style="display: none;">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('delete') }}
                                                                    </form>

                                                                    @include('layouts.master.add-course-form')

                                                                    <div class="collapse" id="collapseForEditSection{{$section->id}}" style="margin-top:1%;">
                                                                        <div class="panel panel-default">
                                                                            <div class="panel-body">
                                                                                <form id="EditSectionForm{{$section->id}}" class="form-horizontal" action="{{route('edit.section', ['id' => $section->id])}}" method="post">
                                                                                    {{csrf_field()}}
                                                                                    <div class="false-padding-bottom-form form-group">
                                                                                        <label for="" class="col-sm-12 control-label false-padding-bottom">{{ __('text.section_name') }}</label>
                                                                                        <div class="col-sm-12">
                                                                                            <input type="text" class="form-control" name="section_number" value="{{$section->section_number}}" required>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <div class="col-sm-12">
                                                                                            <button type="submit" class="button button--save float-right">{{ __('text.Update') }}</button>
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
                                                    <button class="btn btn-info btn-lg mt-5 mb-4" id="create-section-btn-class-{{$class->id}}">+ {{ __('text.create_section') }}</button>
                                                    <button class="btn btn-lg btn-primary ml-3 btn-lg mt-5 mb-4" id="edit-class-info-{{$class->id}}"><i class="far fa-edit"></i>{{ __('text.edit_class_info') }}</button>
                                                    <button class="btn btn-danger btn-lg mt-5 mb-4 ml-3" type="button" onclick="removeClass({{ $class->id }})"><i class="far fa-trash-alt mr-2"> </i>{{ __('text.delete_class') }}
                                                    </button>
                                                    @include('layouts.master.create-section-form')
                                                    <form id="delete-form-{{ $class->id }}" action="{{ route('delete.class', $class->id) }}"
                                                          method="post" style="display: none;">
                                                        {{ csrf_field() }}
                                                        {{ method_field('delete') }}
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                            class="button button--cancel"
                                                            data-dismiss="modal">
                                                        {{ __('text.close') }}
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
