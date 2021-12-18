<?php

namespace App\Mail;

use App\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class newAccountReceivable extends Mailable
{
    use Queueable, SerializesModels;

    private $tenant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Novo Pagamento Gerado');
        $this->to($this->tenant->mail, $this->tenant->first_name . ' ' . $this->tenant->last_name);
        return $this->markdown('mail.new_account_receivable');
    }
}
