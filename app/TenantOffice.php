<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TenantOffice extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'type_work', 'company_name_clt', 'company_name_pj', 'office', 'registration_time', 'rent_monthly', 'tenant_id', 'active'
    ];
}
