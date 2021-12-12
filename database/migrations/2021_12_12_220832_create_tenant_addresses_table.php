<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_addresses', function (Blueprint $table) {
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
        Schema::dropIfExists('tenant_addresses');
    }
}
