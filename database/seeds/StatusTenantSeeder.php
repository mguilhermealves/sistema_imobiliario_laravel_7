<?php

use App\StatusTenant;
use Illuminate\Database\Seeder;

class StatusTenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status_tenants = [
            ['Em Aprovação', 'on_approval', 1],
            ['Aprovado', 'approved', 1],
            ['Não Aprovado', 'not_approved', 1],
        ];

        foreach ($status_tenants as $status_tenant) {
            StatusTenant::create([
                'name' => $status_tenant[0],
                'slug' => $status_tenant[1],
                'active' => $status_tenant[2],
            ]);
        }
    }
}
