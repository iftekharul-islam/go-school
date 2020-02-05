<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invoice of '.$this->data['month'])
            ->cc(['roy.debashish.sj@gmail.com'])
            ->from('roy.debashish.sj@gmail.com', 'Shoroborno')
            ->replyTo('roy.debashish.sj@gmail.com', 'Shoroborno team')
            ->view('payment.invoice-template')->with('data', $this->data);
    }
}
