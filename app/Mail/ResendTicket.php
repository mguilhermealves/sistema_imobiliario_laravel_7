<?php

namespace App\Mail;

use App\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResendTicket extends Mailable
{
    use Queueable, SerializesModels;

    private $tenant;
    private $payment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Tenant $tenant, $payment)
    {
        $this->tenant = $tenant;
        $this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Boleto Reenviado');
        $this->to($this->tenant->mail, $this->tenant->first_name . ' ' . $this->tenant->last_name);
        // $this->attach(storage_path('app/image.jpg')); // passar o caminho do anexo
        return $this->markdown('mail.resend_mail_ticket')->with(['payment' => $this->payment, 'tenant' => $this->tenant]);
    }
}
