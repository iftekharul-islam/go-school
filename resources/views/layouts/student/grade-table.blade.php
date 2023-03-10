@if(count($exams) > 0)
    @foreach($exams as $exam)
        <h4 class="text-muted">Exam Name - {{$exam->exam_name}}</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('text.course') }}</th>
                    <th>{{ __('text.course_teacher') }}</th>
                    <th>{{ __('text.Grades') }}</th>
                    <th>{{ __('text.total_mark') }}</th>
                    <th>{{ __('text.Details') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($grades as $grade)
                    @if($grade->exam_id == $exam->id)
                        <tr id="heading{{($loop->index + 1)}}">
                            <th scope="row">{{($loop->index + 1)}}</th>
                            <td>{{$grade->course->course_name}}</td>
                            <td>
                                <a class="text-teal" href="{{url('user/'.$grade->teacher->student_code)}}">{{$grade->teacher->name}}</a>
                            </td>
                            <td>
                                    @foreach($gradesystems['gradeSystemInfo'] as $gs)
                                        @if($grade->marks >= $gs->marks_from && $grade->marks <= $gs->marks_to)
                                            <b>{{$gs->grade}}</b>
                                            @break
                                        @endif
                                    @endforeach

                            </td>
                            <td><b>{{ round($grade->marks,2 )}}</b></td>
                            <td><a class="button button--save" href="#collapse{{($loop->index + 1)}}" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse{{($loop->index + 1)}}">View</a></td>
                        </tr>
                        <tr class="collapse" id="collapse{{($loop->index + 1)}}" aria-labelledby="heading{{($loop->index + 1)}}" aria-expanded="false">
                            <td colspan="7">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed table-hover">
                                        <thead>
                                        <tr>
                                            <th>Attendance</th>
                                            @for($i=1;$i<=5;$i++)
                                                <th>Quiz {{$i}}</th>
                                            @endfor
                                            @for($i=1;$i<=3;$i++)
                                                <th>Assignment {{$i}}</th>
                                            @endfor
                                            @for($i=1;$i<=5;$i++)
                                                <th>CT {{$i}}</th>
                                            @endfor
                                            @if($grade->course->final_exam_percent > 0)
                                                <th>Written</th>
                                                <th>Mcq</th>
                                            @endif
                                            @if($grade->course->practical_percent > 0)
                                                <th>Practical</th>
                                            @endif
                                            <th>Total</th>
                                            <th>Point</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>{{$grade->attendance}}</td>
                                            @for($i=1;$i<=5;$i++)
                                                <td>{{$grade['quiz'.$i]}}</td>
                                            @endfor
                                            @for($i=1;$i<=3;$i++)
                                                <td>{{$grade['assignment'.$i]}}</td>
                                            @endfor
                                            @for($i=1;$i<=5;$i++)
                                                <td>{{$grade['ct'.$i]}}</td>
                                            @endfor
                                            @if($grade->course->final_exam_percent > 0)
                                                <td>{{$grade->written}}</td>
                                                <td>{{$grade->mcq}}</td>
                                            @endif
                                            @if($grade->course->practical_percent > 0)
                                                <td>{{$grade->practical}}</td>
                                            @endif
                                            <td>{{ round($grade->marks, 2) }}</td>
                                            <td>{{$grade->gpa}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
            <br>
            <br>
        </div>
        <script>
            $("#btnPrint{{$exam->id}}").on("click", function () {
                var tableContent = $('#table-content{{$exam->id}}').html();
                var printWindow = window.open('', '', 'height=720,width=1280');
                printWindow.document.write('<html><head><title>Result Card</title>');
                printWindow.document.write('<link href="{{url('css/app.css')}}" rel="stylesheet">');
                printWindow.document.write('</head><body>');
                printWindow.document.write('<div class="container-fluid"><div class="col-md-12"><h2 style="text-align:center;">{{Auth::user()->school->name}}</h2><h4 style="text-align:center;">Result Card</h4>');
                printWindow.document.write('<h4>Student Name: {{ $studentName ?? ''}}</h4>');
                printWindow.document.write('<h4>Class: {{ $classNumber ?? ''}} <span>Section: {{ $sectionNumber ?? ''}}</span></h4>');
                printWindow.document.write('<h3>Exam Name: {{ $exam->exam_name }}</h3>');
                printWindow.document.write(tableContent);
                printWindow.document.write('</div></div></body></html>');
                printWindow.document.close();
                printWindow.print();
            });
        </script>
    @endforeach
@else
    {{ __('text.No_related_data_notification') }}
@endif
