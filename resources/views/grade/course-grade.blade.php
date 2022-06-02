@extends('layouts.student-app')

@section('title', 'Grade')

@section('content')
  <div class="container-fluid">
    <div class="breadcrumbs-area">
      <h3>
        Assign Grade
      </h3>
      <ul>
        <li> <a href="{{ URL::previous() }}">
            Back &nbsp;&nbsp;|</a>
          <a href="{{ url(current_user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
        </li>
        <li>Assign Grade</li>
      </ul>
    </div>
    <div class="card height-auto false-height">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12" id="main-container">
            @if (session('status'))
              <div class="alert alert-success">
                {{ session('status') }}
              </div>
            @elseif(session('error'))
              <div class="alert alert-danger">
                  {{ session('error') }}
              </div>
            @endif
            @if ($errors->any())115, 116
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            @if($exam)
              <form action="{{url('teacher/courses/save-configuration')}}" method="POST">
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{$course_id}}">
                <div class="card panel-default" id="main-container">
                  @if(count($grades) > 0)
                    @foreach ($grades as $grade)
                      <div class="card-title" style="font-size: 15px;"><b>Course</b> - {{$grade->course->course_name}} &nbsp; <b>Class</b> - {{$grade->course->section->class->class_number}} &nbsp;<b>Section</b> - {{$grade->course->section->section_number}}
                        <b>Examination</b> -  {{ $exam->exam_name }}     <b>Term</b>   -   {{ $exam->term }}
                      </div>
                      @break($loop->first)
                    @endforeach
                    <div class="card-body" style="padding-top: 0px;">
                      <div class="alert alert-info alert-dismissible mt-5" style="font-size:13px; margin-top: 10px;">
                        <ul>
                          <li>
                            Select which Grade System you want to use.
                          </li>
                          <li>
                            <b>How to count:</b> If you want to count the best 2 quizzes out of 3, then quiz count is 2.
                          </li>
                          <li>
                            <b>Percentage Count:</b> Total number of percentage should be 100. You can put 100% to a field or distribute it according to the marks obtained by a student. Please input the full mark of the test for making the Percentage Count work.
                          </li>
                          <li>
                            <b>Full Mark Count:</b> If you take a Class Test where full mark is 15, then Full mark for Class Test is 15.
                          </li>
                            <li>
                                <b>Average Marking formula (CT, Quiz, Assignment):</b> Field percentage * Field marks sum average(Best marks field count) / Field full mark.
                            </li>
                        </ul>
                      </div>
                      <div class="table-responsive">
                        <table class="table display text-nowrap">
                          <thead>
                          <tr>
                            <th>Select Grade System</th>
                              <th>Assignment Count</th>
                              <th>Quiz Count</th>
                            <th>Class Test Count</th>
                          </tr>
                          </thead>
                          <?php
                          $section_id = 0;
                          ?>
                          @foreach ($grades as $grade)
                            <tbody>
                            <tr>
                              <td>
                                <select class="form-control input-sm" name="grade_system_name">
                                  @foreach($gradesystems as $gs)
                                    <option selected>{{$gs->grade_system_name}}</option>
                                  @endforeach
                                </select>
                              </td>
                              <td>
                                <input type="number" class="form-control input-sm" id="assignment-count" name="assignment_count" placeholder="Assignment Count" max="3" value="{{$grade->course->assignment_count}}">
                              </td>
                                <td>
                                    <input type="number" class="form-control input-sm" id="quiz-count" name="quiz_count" placeholder="Quiz Count" max="5" value="{{$grade->course->quiz_count}}">
                                </td>
                              <td>
                                <input type="number" class="form-control input-sm" id="ct-count" name="ct_count" placeholder="CT Count" max="5" value="{{$grade->course->ct_count}}">
                              </td>
                            </tr>
                            <tr>
                                <th>Attendance %</th>
                                <th>Assignment %</th>
                                <th>Quiz %</th>
                                <th>Class Test %</th>
                                <th>Final Exam %</th>
                                <th>Practical %</th>
                                <th>Total %</th>
                            </tr>
                            <tr>
                              <td>
                                <input type="number" onchange="updatePercentage()" class="form-control input-sm" id="attendance" name="attendance_percent" placeholder="Percentage" max="50" value="{{$grade->course->attendance_percent}}">
                              </td>
                              <td>
                                <input type="number" onchange="updatePercentage()" class="form-control input-sm" id="assignment" name="assignment_percent"
                                       placeholder="Percentage" max="50" value="{{$grade->course->assignment_percent}}">
                              </td>
                              <td>
                                <input type="number" onchange="updatePercentage()" class="form-control input-sm" id="quiz" name="quiz_percent" placeholder="Percentage" max="50" value="{{$grade->course->quiz_percent}}">
                              </td>
                              <td>
                                <input type="number" onchange="updatePercentage()" class="form-control input-sm" id="class-test" name="ct_percent" placeholder="Percentage" max="50" value="{{$grade->course->ct_percent}}">
                              </td>
                                <td>
                                    <input type="number" onchange="updatePercentage()" class="form-control input-sm" id="final" name="final_exam_percent" placeholder="Percentage" max="100" value="{{$grade->course->final_exam_percent}}">
                                </td>
                                <td>
                                    <input type="number" onchange="updatePercentage()" class="form-control input-sm" id="practical_percent" name="practical_percent" placeholder="Percentage" max="100" value="{{$grade->course->practical_percent}}">
                                </td>
                                <td>
                                    <input type="number" class="form-control input-sm" id="final_percentage" name="f_percent" placeholder="Percentage"  value="0" readonly>
                                </td>
                            </tr>
                            <tr>
                              <th>Attendance Full Marks</th>
                              <th>Assignment Full Marks</th>
                              <th>Quiz Full Marks</th>
                              <th>CT Full Marks</th>
                              <th>Final Exam Full Marks</th>
                              <th>Practical Full Marks</th>
                              <th>Grand Total</th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="number" onchange="updateFinalMark()" class="form-control input-sm" id="att_full" name="att_fullmark" placeholder="Attendance Full Marks" max="100" value="{{$grade->course->att_fullmark}}">
                                </td>
                                <td>
                                    <input type="number" onchange="updateFinalMark()" class="form-control input-sm" id="a_full" name="a_fullmark" placeholder="Assignment Full Marks" max="20" value="{{$grade->course->a_fullmark}}">
                                </td>
                              <td>
                                <input type="number" onchange="updateFinalMark()" class="form-control input-sm" id="q_full" name="quiz_fullmark" placeholder="Quiz Full Marks" max="20" value="{{$grade->course->quiz_fullmark}}">
                              </td>
                              <td>
                                <input type="number" onchange="updateFinalMark()" class="form-control input-sm" id="ct_full" name="ct_fullmark" placeholder="CT Full Marks" max="20" value="{{$grade->course->ct_fullmark}}">
                              </td>
                              <td>
                                <input type="number" onchange="updateFinalMark()" class="form-control input-sm" id="final_full" name="final_fullmark" placeholder="Final Full Marks" max="100" value="{{$grade->course->final_fullmark}}">
                              </td>
                              <td>
                                <input type="number" onchange="updateFinalMark()" class="form-control input-sm" id="practical_full" name="practical_fullmark" placeholder="Practical Full Marks" max="100" value="{{$grade->course->practical_fullmark}}">
                              </td>
                                <td>
                                    <input type="number" class="form-control input-sm" id="final_mark" name="f_mark" placeholder="Percentage"  value="0" readonly>
                                </td>
                            </tr>
                            </tbody>
                            <?php $section_id = $grade->course->section->id; ?>
                            @break($loop->first)
                          @endforeach
                        </table>
                      </div>
                        <button type="submit" class="button button--save text-center float-right mt-3">
                            <i class="far fa-save mr-2"></i><b>Save Mark Distribution</b>
                        </button>
                    </div>
                  @else
                    <div class="card mt-5 false-height">
                      <div class="card-body">
                        <div class="card-body-body mt-5 text-center">
                            {{ __('text.No_related_data_notification') }}
                        </div>
                      </div>
                    </div>
                  @endif
                </div>
              </form>

              <div class="panel panel-default mt-5">
                @if(count($grades) > 0)
                  <div class="page-panel-title" style="font-size: 15px;">
                    <form class="new-added-form mb-3" action="{{url('teacher/grades/calculate-marks')}}" method="GET">
                      {{csrf_field()}}
                      <span class="font-size-20">Give Marks to Students</span>
                      <input type="hidden" name="course_id" value="{{$course_id}}">
                      <input type="hidden" name="section_id" value="{{$section_id}}">

                      @foreach($gradesystems as $gs)
                        <input type="hidden" name="grade_system_name" value="{{$gs->grade_system_name}}">
                      @endforeach
                      <input type="hidden" name="exam_id" value="{{$exam->id}}">
                      <input type="hidden" name="teacher_id" value="{{$teacher_id}}">
                      <button type="submit" class="button button--save ml-3 float-right">
                        <b>Get Total Marks</b>
                      </button>
                    </form>
                  </div>
                  <div class="panel-body">
                    @include('layouts.teacher.grade-form')
                  </div>
                @else
                  <div class="card mt-5 false-height">
                    <div class="card-body">
                      <div class="card-body-body mt-5 text-center">
                          {{ __('text.No_related_data_notification') }}
                      </div>
                    </div>
                  </div>
                @endif
              </div>
            @else
              <div class="panel-body">
                You can not submit grade as there's no examination available for this course.
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('customjs')
    <script>
        function updatePercentage() {
            let attendance = parseInt($("#attendance").val());
            let assignment = parseInt($("#assignment").val());
            let quiz = parseInt($("#quiz").val());
            let ct = parseInt($("#class-test").val());
            let final = parseInt($("#final").val());
            let practical = parseInt($("#practical_percent").val());
            let total = attendance + assignment + quiz + ct + final + practical;
            $("#final_percentage").val(total);

            if($("#final_percentage").hasClass('text-danger')){
                $("#final_percentage").removeClass('text-danger')
            }
            if(total > 100){
                $("#final_percentage").addClass('text-danger')
            }
        }

        function updateFinalMark() {
            let attendance = parseInt($("#att_full").val());
            let assignment = parseInt($("#a_full").val());
            let quiz = parseInt($("#q_full").val());
            let ct = parseInt($("#ct_full").val());
            let final = parseInt($("#final_full").val());
            let practical = parseInt($("#practical_full").val());
            let total = attendance + assignment + quiz + ct + final + practical;
            $("#final_mark").val(total);

            if($("#final_mark").hasClass('text-danger')){
                $("#final_mark").removeClass('text-danger')
            }
            if(total > 100){
                $("#final_mark").addClass('text-danger')
            }
        }

        $(function () {
            var i;
            for (i = 6; i < 18; i++) {
                if (i == 10 || i == 13)
                    continue;
                $("#marking-table td:nth-child(" + i + "),#marking-table th:nth-child(" + i + ")").show();
            }
            $(":checkbox").change(function () {
                if ($(this).is(':checked')) {
                    $("#marking-table td:nth-child(" + $(this).val() + "), #marking-table th:nth-child(" + $(this).val() +
                        ")").show();
                } else {
                    $("#marking-table td:nth-child(" + $(this).val() + "),#marking-table th:nth-child(" + $(this).val() +
                        ")").hide();
                    $("#marking-table td:nth-child(" + $(this).val() + ")").find('input').val('0');
                }
            });
            updatePercentage();
            updateFinalMark();
        });
    </script>
@endpush
