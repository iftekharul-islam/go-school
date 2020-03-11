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
            ->cc(['hasanuzzaman@augnitive.com'])
            ->from('hasanuzzaman@augnitive.com', 'Shoroborno')
            ->replyTo('hasanuzzaman@augnitive.com', 'Shoroborno')
            ->view('payment.invoice-template')->with('data', $this->data);
    }
}
