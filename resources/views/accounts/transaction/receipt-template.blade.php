<!DOCTYPE html>
<html>
<head>
    <title>Money Receipt</title>
    <style>
        body{
            font-size:16px;
            color: #000;
        }
        #content{
            width:100%;
            margin:0 auto;
            height: 50%;
            -webkit-transform: rotate(90deg);
            -ms-transform: rotate(90deg); 
            transform: rotate(90deg);
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
            padding: 8px;
            text-align:left;
            border: 1px solid #000;
        }
        table {border-collapse: collapse;}

        .student-info th, .student-info td {
            border: 1px solid black;
        }
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
            width: 250px;
            display: block;
            text-align: center;
        }
        #signature{margin-top: 50px;}
        .align-left td{text-align: left !important}
        .align-right{text-align: right !important}
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
                    <small>Student Copy</small>
                    <h3>Maritime International School</h3>
                    <address>
                        House 941, Road 14, Avenue 2, Mirpur DOHS, Dhaka-1207
                    </address>
                </td>
            </tr>
        </table>

        <table>
            <tr class="align-left">
                <td>No:..........</td>
                <td>Date:..........</td>
            </tr>
            <tr class="align-left">
                <td>Student Name:..........</td>
                <td></td>
                <td></td>
            </tr>
            <tr class="align-left">
                <td>Class:..........</td>
                <td>Roll: ..........</td>
                <td>Section: ..........</td>
            </tr>
        </table>
        <div class="student-info">
            <table  width="100%">
                <thead>
                    <th width="10%">SL</th>
                    <td width="70%">Particulars</td>
                    <td width="20%" class="align-right">Taka</td>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Admission / Re-admission Fee</td>
                        <td class="align-right">32000</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Admission Form</td>
                        <td class="align-right">3000</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Transport</td>
                        <td class="align-right">1500</td>
                    </tr>
                     <tr>
                        <td>&nbsp;</td>
                        <td class="align-right"><b>Total</b></td>
                        <td class="align-right"><b>32000</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
         <table id="signature">
            <tr>
                <td width="50%" class="signature">
                    <span >Officer's Signature</span>
                </td>
                <td width="50%" class="signature">
                    <span >Receiver's Signature</span>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
