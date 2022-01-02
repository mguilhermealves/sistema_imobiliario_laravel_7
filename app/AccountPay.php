<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AccountPay extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'company_beneficiary', 'amount', 'is_recorrency', 'day_due', 'payment_method', 'comments', 'account_category_id', 'active'
    ];

    /**
     * Get category account.
     */
    public function category()
    {
        return $this->hasOne('App\AccountPayCategory', 'id', 'account_category_id');
    }

    /**
     * Get category account.
     */
    public function method_payment()
    {
        return $this->hasOne('App\MethodPayment', 'slug', 'payment_method');
    }
}
