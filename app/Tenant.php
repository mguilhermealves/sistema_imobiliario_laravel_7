<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Tenant extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'first_name', 'last_name', 'mail', 'cpf_cnpj', 'rg', 'cnh', 'phone', 'celphone', 'genre', 'marital_status', 'is_children', 'is_pet','pet_species', 'number_residents', 'active'
    ];

    /**
     * Get address for tenant.
     */
    public function address()
    {
        return $this->hasOne('App\TenantAddress', 'tenant_id', 'id');
    }

    /**
     * Get for partner for tenant.
     */
    public function partner()
    {
        return $this->hasOne('App\TenantPartner', 'tenant_id', 'id');
    }

    /**
     * Get for office for tenant.
     */
    public function office()
    {
        return $this->hasOne('App\TenantOffice', 'tenant_id', 'id');
    }

    /**
     * Get for files for tenant.
     */
    public function files()
    {
        return $this->hasMany('App\TenantFile', 'tenant_id', 'id');
    }
}
