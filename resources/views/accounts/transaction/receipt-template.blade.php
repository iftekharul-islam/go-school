<!DOCTYPE html>
<html>
<head>
    <title>Money Receipt-{{$student_name}}</title>
    <style>
        body{
            font-size:14px;
            color: #000;
        }
        .main
        .main{
            width:100%;
            margin:0 auto;
           
        }
        .content{
            width: 45%;
            
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
            font-size: 12px;
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
            size: landscape;
        }
        
    </style>
</head>

<body>
    <div id="main">
    <div class="content" style="display:inline-block; width: 48%; float:left;">
        <table id="heading">
            <tr>
                <td>
                    <small>Student Copy</small>
                    <h3>{{ $school_name }}</h3>
                    <address>
                        {{ $school_address }}
                    </address>
                </td>
            </tr>
        </table>
        <br>
        <table>
            <tr class="align-left">
                <td>Transaction no: {{ $transaction['transaction_serial'] }}</td>
                <td>Date: {{ $transaction['created_at']->format('d-m-Y') }}</td>
            </tr>
            <tr class="align-left">
                <td>Name: {{ $student_name }}</td>
                <td>Roll: {{ $roll_number ?? 'N/A' }}</td>
            </tr>
            <tr class="align-left">
                <td>Class: {{ $class }}</td>
                <td>Section: {{ $section }}</td>
            </tr>
        </table>
        <br>
        <div class="student-info">
            <table  width="100%">
                <thead>
                    <th width="10%">SL</th>
                    <td width="70%">Particulars</td>
                    <td width="20%" class="align-right">Taka</td>
                </thead>
                <tbody>
                    @if ( !empty($transaction['transaction_items']) )
                        @foreach ( $transaction['transaction_items'] as $index => $item )
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['fee_type']['name'] }}</td>
                                <td style="text-align:right">{{ number_format($item['fee_amount'], 2) }}</td>
                            </tr>
                        @endforeach
                    @endif
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align:right">Fine</td>
                        <td style="text-align:right">{{ number_format($transaction['fine'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align:right">Sub Total</td>
                        <td style="text-align:right">{{ number_format(($total_amount + $transaction['fine']), 2) }}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align:right">Discount</td>
                        <td style="text-align:right">{{ number_format($transaction['discount'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align:right">Partial</td>
                        <td style="text-align:right">{{ number_format(( $grand_total - ($transaction->amount + $transaction->deducted_advance_amount) ), 2) }}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        @if( $grand_total > ($partial + $transaction->deducted_advance_amount))
                            <td><b>Due Amount</b></td>
                            <td><b>{{ number_format(($grand_total - ($partial + $transaction->deducted_advance_amount) ), 2) }}</b></td>
                        @else
                            <td style="text-align:right"><b>Paid Amount</b></td>
                            <td style="text-align:right"><b>{{ number_format(($grand_total), 2) }}</b></td>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
        
         <table id="signature">
            <tr>
                <td width="50%" style="text-align:left;">
                    <span style="border-top:1px dashed #000">Officer's Signature</span>
                </td>
                <td width="50%" style="text-align:right">
                    <span style="border-top:1px dashed #000">Receiver's Signature</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="content" style="display:inline-block; width: 48%; float:right">
        <table id="heading">
            <tr>
                <td>
                    <small>Office Copy</small>
                    <h3>{{ $school_name }}</h3>
                    <address>
                        {{ $school_address }}
                    </address>
                </td>
            </tr>
        </table>
        <br>
        <table>
            <tr class="align-left">
                <td>Transaction no: {{ $transaction['transaction_serial'] }}</td>
                <td>Date: {{ $transaction['created_at']->format('d-m-Y') }}</td>
            </tr>
            <tr class="align-left">
                <td>Name: {{ $student_name }}</td>
                <td>Roll: {{ $roll_number ?? 'N/A' }}</td>
            </tr>
            <tr class="align-left">
                <td>Class: {{ $class }}</td>
                <td>Section: {{ $section }}</td>
            </tr>
        </table>
        <br>
        <div class="student-info">
            <table  width="100%">
                <thead>
                    <th width="10%">SL</th>
                    <td width="70%">Particulars</td>
                    <td width="20%" class="align-right">Taka</td>
                </thead>
                <tbody>
                    @if ( !empty($transaction['transaction_items']) )
                        @foreach ( $transaction['transaction_items'] as $index => $item )
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['fee_type']['name'] }}</td>
                                <td style="text-align:right">{{ number_format($item['fee_amount'], 2) }}</td>
                            </tr>
                        @endforeach
                    @endif
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align:right">Fine</td>
                        <td style="text-align:right">{{ number_format($transaction['fine'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align:right">Sub Total</td>
                        <td style="text-align:right">{{ number_format(($total_amount + $transaction['fine']), 2) }}</td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align:right">Discount</td>
                        <td style="text-align:right">{{ number_format($transaction['discount'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align:right">Partial</td>
                        <td style="text-align:right">{{ number_format(( $grand_total - ($transaction->amount + $transaction->deducted_advance_amount) ), 2) }}</td>
                    </tr>
                    <tr>
                            <td>&nbsp;</td>
                        @if( $grand_total > ($partial + $transaction->deducted_advance_amount))
                            <td><b>Due Amount</b></td>
                            <td><b>{{ number_format(($grand_total - ($partial + $transaction->deducted_advance_amount) ), 2) }}</b></td>
                        @else
                            <td style="text-align:right"><b>Paid Amount</b></td>
                            <td style="text-align:right"><b>{{ number_format(($grand_total), 2) }}</b></td>
                        @endif
                    </tr>
                </tbody>
            </table>
        </div>
        
         <table id="signature">
            <tr>
                <td width="50%" style="text-align:left;">
                    <span style="border-top:1px dashed #000">Officer's Signature</span>
                </td>
                <td width="50%" style="text-align:right">
                    <span style="border-top:1px dashed #000">Receiver's Signature</span>
                </td>
            </tr>
        </table>
    </div>
    </div>
</body>

</html>
