<!DOCTYPE html>
<html>
<head>
    <title>Invoice of {{ $data['month'] }} </title>
    <style>
        body{font-size:16px}
        #content{
            width:80%;
            margin:0 auto;
        }
        table{
            width:100%;
            border-collapse: collapse;    
        }
        td{
            padding-left:10px;
            padding-right:10px;
        }
        .align-right{text-align:right}
        h3, #billing{margin-bottom:10px}
        #heading{
            margin-bottom: 20px;
            background-color: #26796f;
            color: #fff;
        }
        #heading address{padding-bottom: 15px}
        #billing td{padding-left:0}
        #billing h3{margin-bottom:0}
        .biling-title{border-bottom: 1px solid #26796f}
    </style>
</head>

<body>
    <div id="content">
       
        <table id="heading">
            <tr>
                <td width="80%">
                    <h2>Shoroborno</h2>
                    <address>
                        H# 941, Road 14, Avenue 2, Mirpur DOHS, Dhaka 1212.<br/>
                        Contact: 01521245788
                    </address>
                </td>
                <td ><h3>Invoice</h3><p>{{ date('d F Y') }}</p></td>
            </tr>
        </table>
        
        <table id="billing">
            <tr><td><h3 class="biling-title">Bill To</h3></td></tr>
            <tr>
                <td width="80%">
                    <h3>{{ $data['schoolName'] }}</h3>
                    <address>
                        {{ $data['schoolAddress'] }}
                    </address>
                </td>
            </tr>
        </table>
     
        <table border="1" width="600px">
            <caption><h3>{{ $data['month'] }}</h3></caption>
            <tr>
                <th>Service</th>
                <th>Total</th>
                <th>Cost/ Item</th>
                <th>Total Cost</th>
            </tr>
            <tr>
                <td>Student</td>
                <td>{{ $data['totalStudent'] }}</td>
                <td>{{ $data['per_student_cost'] }}</td>
                <td class="align-right">{{ number_format($data['serviceCharge'], 2) }}</td>
            </tr>
            <tr>
                <td>SMS</td>
                <td>{{ $data['totalSms'] }}</td>
                <td>{{ $data['per_sms_cost'] }}</td>
                <td class="align-right">{{ number_format($data['smsCost'], 2) }}</td>
            </tr>
            <tr>
                <td class="align-right" colspan="3"><b>Total (BDT) = </b></td>
                <td class="align-right"><b>{{ number_format($data['smsCost'] + $data['serviceCharge'], 2) }}</b></td>
            </tr>
           
        </table>
    </div>
</body>

</html>