<!DOCTYPE html>
<html>
<head>
    <title>Admit Card</title>
    <style>
        body{
            font-size:16px;
            color: #000;
        }
        #content{
            width:100%;
            margin:0 auto;
        }
        table{
            width:100%;
            border-collapse: collapse;
            text-align:left;
        }
        td{
            padding-left:10px;
            padding-right:10px;
        }
        .align-right{text-align:right}
        #billing{margin-bottom:10px}
        #heading{
            text-align: center;
        }
        #heading address{
            padding-bottom: 15px;
            font-size: 14px;
        }
        #heading h1{margin: 10px}
        #billing td{padding-left:0}
        #billing h3{margin-bottom:0}
        .biling-title{
            border-bottom: 1px solid #26796f;
            text-align: center;
        }
        .school-logo{
            max-height: 60px;
            width:auto;
        }
        .student-info td, .student-info th{
            padding: 8px 0;
            text-align:left;
        }
        .student-pic{max-width:250px}
        .instruction{
            border: 1px solid #eee;
            padding: 0 10px;
            margin-top: 30px;
            overflow: hidden;
        }
        .instruction ol{
            font-size: 14px;
            line-height: 2;
        }
        .signature{text-align:right;}
        .signature span{
            font-weight:bold;
            border-top: 1px solid #000;
            padding: 10px;
            margin-top:50px;
            width: 250px;
            display: block;
            text-align: center;
        }
        #signature{margin-top: 50px;}
        @page {
            header: page-header;
            footer: page-footer;
        }
    </style>
</head>

<body>
    <div id="content">
        <table id="heading">
            <tr>
                <td>
                    @if($school['logo'])
                        <img src="{{ url($school['logo']) }}" alt="School Logo"  class="school-logo" />
                    @endif
                    <h3>{{ $school['name'] }}</h3>
                    <address>
                        {{ $school['school_address'] }}
                    </address>
                </td>
            </tr>
        </table>
        <h3 class="biling-title">Admit Card</h3>
        <div class="student-info">
            <table  width="100%">
                <tr>
                    <td width="80%">
                        <table width="100%">
                            <tr>
                                <th width="25%">Student Name</th>
                                <td width="75%">{{ $name }}</td>
                            </tr>
                            <tr>
                                <th>Roll Number</th>
                                <td>{{ $roll_number }}</td>
                            </tr>
                            <tr>
                                <th>Class & Section</th>
                                <td>{{ $class.'('.$section.')' }}</td>
                            </tr>
                            <tr>
                                <th>Exam Type</th>
                                <td>04 February 2020</td>
                            </tr>
                            <tr>
                                <th>Exam Date</th>
                                <td>04 February 2020</td>
                            </tr>
                            <tr>
                                <th>Father's Name</th>
                                <td>{{ $father_name }}</td>
                            </tr>
                            <tr>
                                <th>Mother's Name</th>
                                <td>{{ $mother_name }}</td>
                            </tr>
                        </table>
                    </td>
                    <td width="20%">
                        @if($student_pic)
                            <img src="{{ url($student_pic) }}" class="student-pic" />
                        @else
                            <img src="{{ asset('/placeholder-300x300.jpg') }}" class="student-pic" />
                        @endif
                    </td>
                </tr>
            </table>
            <table id="signature">
                <tr>
                    <td width="">&nbsp;</td>
                    <td width="25%" class="signature">
                        <span >Signature Of Principal</span>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="instruction">
            <h3>General Instruction</h3>
            <ol>
                <li>Each candidate must bring printed copy of this admit card into the exam hall.</li>
                <li>Candidate should be present in the concerned center in 30(thirty) minute before the exam starts.</li>
                <li>Carring any kind of electronic device like the mobile phone is strongly prohibited.</li>
            </ol>
        </div>
    </div>
    <htmlpagefooter name="page-footer">
        {{ date('d M Y g:i:s a') }}
    </htmlpagefooter>
</body>

</html>
