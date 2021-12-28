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
        'id', 'address', 'number_address', 'complement', 'code_postal', 'district', 'city', 'uf', 'tenant_id', 'propertie_id', 'type_propertie', 'object_propertie', 'active'
    ];

    /**
     * Get for objetivie for properties.
     */
    public function objetivie_properties()
    {
        return $this->hasOne('App\ObjectivePropertie', 'slug', 'object_propertie');
    }

    /**
     * Get for type for propertie.
     */
    public function type_properties()
    {
        return $this->hasOne('App\TypePropertie', 'slug', 'type_propertie');
    }
}
