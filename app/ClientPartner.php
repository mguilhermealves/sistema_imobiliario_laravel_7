<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ClientPartner extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'first_name_partner', 'last_name_partner', 'cpf_cnpj_partner', 'rg_partner', 'cnh_partner', 'active'
    ];

    /**
     * Get partner for client.
     */
    public function file()
    {
        return $this->hasOne('App\ClientPartnerFile', 'clients_partners_id', 'id');
    }
}
