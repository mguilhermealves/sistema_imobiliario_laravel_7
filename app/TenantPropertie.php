<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TenantPropertie extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'address', 'number_address', 'complement', 'code_postal', 'district', 'city', 'uf', 'tenant_id', 'propertie_id', 'active'
    ];
}
