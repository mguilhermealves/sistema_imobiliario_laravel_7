<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_properties', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable()->default(NULL);
            $table->string('number_address')->nullable()->default(NULL);
            $table->string('complement')->nullable()->default(NULL);
            $table->string('code_postal')->nullable()->default(NULL);
            $table->string('district')->nullable()->default(NULL);
            $table->string('city')->nullable()->default(NULL);
            $table->string('uf')->nullable()->default(NULL);
            $table->string('active');
            $table->foreignId('tenant_id')->nullable();
            $table->foreignId('propertie_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->foreign('propertie_id')->references('id')->on('properties');
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
        Schema::dropIfExists('tenant_properties');
    }
}
