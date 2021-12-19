<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AccountReceivableBankSlip extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'barcode', 'link', 'pdf', 'expire_at', 'charge_id', 'status', 'historic_bank', 'total', 'payment', 'account_receivables_id', 'active'
    ];
}
