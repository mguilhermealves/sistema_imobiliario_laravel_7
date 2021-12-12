<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable()->default(NULL);
            $table->string('last_name')->nullable()->default(NULL);
            $table->string('mail')->unique();
            $table->string('cpf_cnpj')->unique();
            $table->string('rg')->nullable()->default(NULL);
            $table->string('cnh')->nullable()->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('celphone')->nullable()->unique();
            $table->string('genre')->nullable()->default(NULL);
            $table->string('marital_status')->nullable()->default(NULL);
            $table->string('is_children')->nullable()->default(NULL);
            $table->string('is_pet')->nullable()->default(NULL);
            $table->string('pet_species')->nullable()->default(NULL);
            $table->string('number_residents')->nullable()->default(NULL);
            $table->string('is_aproved')->nullable()->default(NULL);
            $table->string('comments')->nullable()->default(NULL);
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
        Schema::dropIfExists('tenants');
    }
}
