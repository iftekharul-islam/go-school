<?php

namespace App\Listeners;

use App\Events\ReceiptGenerate;
use App\FeeTransaction;
use App\User;
use Carbon\Carbon;
use PDF;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReceiptDownload
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ReceiptGenerate  $event
     * @return void
     */
    public function handle(ReceiptGenerate $event)
    {
        $transaction = FeeTransaction::with('feeMasters.feeType')->findOrFail($event->transaction_id);
        $student = User::with('section.class','studentInfo')->findOrFail($transaction['student_id']);

        $data = ['student_name' => $student['name'],
            'roll_number' => $student['studentInfo']['roll_number'],
            'section' => $student['section']['section_number'],
            'class' => $student['section']['class']['class_number'],
            'transaction' => $transaction
        ];
        $pdf = PDF::loadView('accounts.transaction.receipt-template', $data, ['format' => 'A4-L', 'orientation' => 'L']);
        $date = Carbon::now();
        $pdfName = $student['student_code'].'_'.$student['name'].'_'.$date->format('Y-m-d_g-i-a').'_receipt.pdf';
        $pdf->stream($pdfName);
    }
}
