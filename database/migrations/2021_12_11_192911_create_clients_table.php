<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
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
            $table->string('address')->nullable()->default(NULL);
            $table->string('number_address')->nullable()->default(NULL);
            $table->string('complement')->nullable()->default(NULL);
            $table->string('code_postal')->nullable()->default(NULL);
            $table->string('district')->nullable()->default(NULL);
            $table->string('city')->nullable()->default(NULL);
            $table->string('uf')->nullable()->default(NULL);
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
        Schema::dropIfExists('clients');
    }
}
