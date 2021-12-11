<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Propertie extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'address', 'number_address', 'complement', 'code_postal', 'district', 'city', 'uf', 'type_propertie', 'object_propertie', 'deadline_contract', 'financial_propertie', 'financer_name', 'price_condominium', 'price_location', 'price_sale', 'price_iptu', 'isswap', 'comments', 'client_propertie_id', 'active',
    ];

    /**
     * Get images for propertie.
     */
    public function images()
    {
        return $this->hasMany('App\PropertiesImages', 'properties_id', 'id');
    }

    /**
     * Get for properties for clients.
     */
    public function client_properties()
    {
        return $this->hasOne('App\Client', 'id', 'client_propertie_id');
    }
}
