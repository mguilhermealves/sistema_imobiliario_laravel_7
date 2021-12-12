<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_offices', function (Blueprint $table) {
            $table->id();
            $table->string('type_work')->nullable()->default(NULL);
            $table->string('company_name_clt')->nullable()->default(NULL);
            $table->string('company_name_pj')->nullable()->default(NULL);
            $table->string('office')->unique();
            $table->string('registration_time')->nullable()->default(NULL);
            $table->string('rent_monthly')->nullable()->unique();
            $table->string('active');
            $table->foreignId('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenant_offices');
    }
}
