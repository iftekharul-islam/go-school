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
                        Contact: +8801886614533
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
            @if($data['payment_type'] == 'monthly')
                <tr>
                    <td>Service Charge</td>
                    <td>--</td>
                    <td>{{ $data['charge'] }}</td>
                    <td class="align-right">{{ number_format($data['charge'], 2) }}</td>
                </tr>
            @else
                <tr>
                    <td>Student</td>
                    <td>{{ $data['totalStudent'] }}</td>
                    <td>@empty($data['charge']) 0.00 @else {{ $data['charge'] }} @endif</td>
                    <td class="align-right">{{ number_format($data['serviceCharge'], 2) }}</td>
                </tr>
            @endif
            <tr>
                <td>SMS</td>
                <td>{{ $data['totalSms'] }}</td>
                <td>@empty($data['per_sms_cost']) 0.00 @else {{ $data['per_sms_cost'] }} @endif</td>
                <td class="align-right">{{ number_format($data['smsCost'], 2) }}</td>
            </tr>
            <tr>
                <td><input type="checkbox" @if($data['is_sms_enable'] == 1) checked @endif style="pointer-events: none"/> SMS</td>
                <td></td>
                <td></td>
                <td class="align-right"></td>
            </tr>
            <tr>
                <td class="align-right" colspan="3"><b>Total (BDT) = </b></td>
                <td class="align-right">
                    @php
                        $grandTotal = 0;
                        if ($data['payment_type'] == 'monthly') {
                            $grandTotal = $data['smsCost'] +  $data['charge'];
                        } else {
                            $grandTotal = $data['smsCost'] +  $data['serviceCharge'];
                        }
                    @endphp
                    <b>{{ number_format($grandTotal, 2) }}</b>
                </td>
            </tr>
           
        </table>
    </div>
</body>

</html>
