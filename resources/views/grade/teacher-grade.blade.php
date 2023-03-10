@extends('layouts.student-app')

@section('title', 'Grades of Students')

@section('content')
  <div class="container-fluid">
    <div class="breadcrumbs-area">
      <h3>
        Submit Grade
      </h3>
      <ul>
        <li> <a href="{{ URL::previous() }}" style="color: #32998f!important;">
            Back &nbsp;&nbsp;|</a>
          <a style="margin-left: 8px;" href="{{ url(\Illuminate\Support\Facades\Auth::user()->role.'/home') }}">&nbsp;&nbsp;Home</a>
        </li>
        <li>Submit Grade</li>
      </ul>
    </div>

    <div class="card height-auto false-height">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12" id="main-container">
            <div class="panel panel-default">
              @if(count($grades) > 0)
                <div class="panel-body">
                  @if (session('status'))
                    <div class="alert alert-success">
                      {{ session('status') }}
                    </div>
                  @endif
                  @foreach ($grades as $grade)
                    <h4>
                      Marks Given by
                      @if(count($grades) > 0)
                        @foreach ($grades as $grade)
                          <b>Teacher Code</b> - {{$grade->teacher->student_code}} &nbsp;<b>Name</b> - {{$grade->teacher->name}}
                          @break($loop->first)
                        @endforeach
                      @else
                            {{ __('text.No_related_data_notification') }}
                      @endif
                    </h4>
                    <br>
                    <div class="row" style="margin-bottom: 2%;">
                      <div class="col-md-10">
                        <b>Course - </b> {{$grade->course->course_name}}
                        <b>Class - </b> {{$grade->course->section->class->class_number}} <b>Section - </b> {{$grade->course->section->section_number}}
                        <b>Exam - </b> {{ isset($grade->exam->exam_name) ? $grade->exam->exam_name: 'No Exam Assigned'  }}
                      </div>
                    </div>
                    <div class="row">
                      @if($grade->course->quiz_count > 0)
                        <div class="col-md-4">
                          <div class="alert alert-info" role="alert">
                            <ul>
                              <li>Quiz Counted Best <span class="label label-success">{{$grade->course->quiz_count}}</span></li>
                            </ul>
                          </div>
                        </div>
                      @endif
                      @if($grade->course->assignment_count > 0)
                        <div class="col-md-4">
                          <div class="alert alert-info" role="alert">
                            <ul>
                              <li>Assignment Counted Best <span class="label label-success">{{$grade->course->assignment_count}}</span></li>
                            </ul>
                          </div>
                        </div>
                      @endif
                      @if($grade->course->ct_count > 0)
                        <div class="col-md-4">
                          <div class="alert alert-info" role="alert">
                            <ul>
                              <li>Class Test Counted Best <span class="label label-success">{{$grade->course->ct_count}}</span></li>
                            </ul>
                          </div>
                        </div>
                      @endif
                    </div>
                    @break($loop->first)
                  @endforeach
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
            @if(count($grades) > 0)
              @include('layouts.teacher.grade-table')
            @else
                          <span style="text-align: center"{{ __('text.No_related_data_notification') }}</span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    (function ( $ ) {

      $.fn.BootSideMenu = function( options ) {

        var oldCode, newCode, side;

        newCode = "";

        var settings = $.extend({
          side:"left",
          autoClose:true
        }, options );

        side = settings.side;
        autoClose = settings.autoClose;

        this.addClass("container sidebar");

        if(side=="left"){
          this.addClass("sidebar-left");
        }else if(side=="right"){
          this.addClass("sidebar-right");
        }else{
          this.addClass("sidebar-left");
        }

        oldCode = this.html();

        newCode += "<div class=\"row\">\n";
        newCode += "	<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg1-12\" data-side=\""+side+"\">\n"+ oldCode+" </div>\n";
        newCode += "</div>";
        newCode += "<div class=\"toggler\">\n";
        newCode += "	<span class=\"glyphicon glyphicon-chevron-right\">&nbsp;</span> <span class=\"glyphicon glyphicon-chevron-left\">&nbsp;</span>\n";
        newCode += "</div>\n";

        this.html(newCode);

        if(autoClose){
          $(this).find(".toggler").trigger("click");
        }

      };

      $(document).on('click', '.sidebar .list-group-item', function(){
        $('.sidebar .list-group-item').each(function(){
          $(this).removeClass('active');
        });
        $(this).addClass('active');
      });


      $(document).on('click', '.sidebar .list-group-item', function(event){
        var idToToggle, this_offset, this_x, this_y, href, side;
        event.preventDefault();
        href = $(this).attr('href');

        if(href.substr(0,1)=='#'){

          idToToggle = href.substr(1,href.length);

          if(searchSubMenu(idToToggle)){

            this_offset = $(this).offset();
            side = $(this).parent().parent().attr('data-side');

            if(side=='left'){
              this_x = $(this).width() + 10;
              this_y = this_offset.top +1;
              $('#'+idToToggle).css('left', this_x);
              $('#'+idToToggle).css('top', this_y);
            }else if(side=='right'){
              this_x = $(this).width()+10;
              this_y = this_offset.top +1;
              $('#'+idToToggle).css('right', this_x);
              $('#'+idToToggle).css('top', this_y);
            }

            $('#'+idToToggle).fadeIn();

          }else{
            $('.submenu').fadeOut();
          }
        }
      });


      $(document).on('click','.toggler', function(){
        var toggler = $(this);
        var container = toggler.parent();
        var listaClassi = container[0].classList;
        var side = getSide(listaClassi);
        var containerWidth = container.width();
        var status = container.attr('data-status');
        if(!status){
          status = "opened";
        }
        doAnimation(container, containerWidth, side, status);
      });

      /*Cerca un div con classe submenu e id uguale a quello passato*/
      function searchSubMenu(id){
        var found = false;
        $('.submenu').each(function(){
          var thisId = $(this).attr('id');
          if(id==thisId){
            found = true;
          }
        });
        return found;
      }

//restituisce il lato del sidebar in base alla classe che trova settata
      function getSide(listaClassi){
        var side;
        for(var i = 0; i<listaClassi.length; i++){
          if(listaClassi[i]=='sidebar-left'){
            side = "left";
            break;
          }else if(listaClassi[i]=='sidebar-right'){
            side = "right";
            break;
          }else{
            side = null;
          }
        }
        return side;
      }
//esegue l'animazione
      function doAnimation(container, containerWidth, sidebarSide, sidebarStatus){
        var toggler = container.children()[1];
        if(sidebarStatus=="opened"){
          if(sidebarSide=="left"){
            container.animate({
              left:-(containerWidth+2)
            });
            toggleArrow(toggler, "left");
          }else if(sidebarSide=="right"){
            container.animate({
              right:- (containerWidth +2)
            });
            toggleArrow(toggler, "right");
          }
          container.attr('data-status', 'closed');
        }else{
          if(sidebarSide=="left"){
            container.animate({
              left:0
            });
            toggleArrow(toggler, "right");
          }else if(sidebarSide=="right"){
            container.animate({
              right:0
            });
            toggleArrow(toggler, "left");
          }
          container.attr('data-status', 'opened');

        }

      }

      function toggleArrow(toggler, side){
        if(side=="left"){
          $(toggler).children(".glyphicon-chevron-right").css('display', 'block');
          $(toggler).children(".glyphicon-chevron-left").css('display', 'none');
        }else if(side=="right"){
          $(toggler).children(".glyphicon-chevron-left").css('display', 'block');
          $(toggler).children(".glyphicon-chevron-right").css('display', 'none');
        }
      }

    }( jQuery ));

  </script>
  <script type="text/javascript">
    $('#grading-menu').BootSideMenu({side:"left", autoClose:false});
  </script>
@endsection
