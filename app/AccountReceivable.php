<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AccountReceivable extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'description', 'status_payment', 'day_due', 'fees', 'fine', 'amount', 'payment_method', 'tenant_id', 'active'
    ];
}
