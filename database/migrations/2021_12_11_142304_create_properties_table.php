<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('address')->nullable()->default(NULL);
            $table->string('number_address')->nullable()->default(NULL);
            $table->string('complement')->nullable()->default(NULL);
            $table->string('code_postal')->nullable()->default(NULL);
            $table->string('district')->nullable()->default(NULL);
            $table->string('city')->nullable()->default(NULL);
            $table->string('uf')->nullable()->default(NULL);
            $table->string('type_propertie')->nullable()->default(NULL);
            $table->string('object_propertie')->nullable()->default(NULL);
            $table->string('deadline_contract')->nullable()->default(NULL);
            $table->string('financial_propertie')->nullable()->default(NULL);
            $table->string('financer_name')->nullable()->default(NULL);
            $table->string('price_condominium')->nullable()->default(NULL);
            $table->string('price_location')->nullable()->default(NULL);
            $table->string('price_sale')->nullable()->default(NULL);
            $table->string('price_iptu')->nullable()->default(NULL);
            $table->string('isswap')->nullable()->default(NULL);
            $table->string('comments')->nullable()->default(NULL);
            $table->string('client_propertie_id')->nullable();
            $table->string('active');
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
        Schema::dropIfExists('properties');
    }
}
