<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'first_name', 'last_name', 'mail', 'cpf_cnpj', 'rg', 'cnh', 'phone', 'celphone', 'genre', 'marital_status', 'address', 'number_address', 'complement', 'code_postal', 'district', 'city', 'uf', 'active'
    ];

    /**
     * Get partner for client.
     */
    public function partner()
    {
        return $this->hasOne('App\ClientPartner', 'clients_id', 'id');
    }
}
