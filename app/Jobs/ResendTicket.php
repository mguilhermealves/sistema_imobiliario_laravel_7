<?php

namespace App\Jobs;

use App\Mail\ResendTicket as MailResendTicket;
use App\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ResendTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    private $tenant;
    private $payment;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Tenant $tenant, $payment)
    {
        $this->tenant = $tenant;
        $this->payment = $payment;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new MailResendTicket($this->tenant, $this->payment));
    }
}
