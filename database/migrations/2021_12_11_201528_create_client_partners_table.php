<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_partners', function (Blueprint $table) {
            $table->id();
            $table->string('first_name_partner')->nullable()->default(NULL);
            $table->string('last_name_partner')->nullable()->default(NULL);
            $table->string('cpf_cnpj_partner')->unique();
            $table->string('rg_partner')->nullable()->default(NULL);
            $table->string('cnh_partner')->nullable()->unique();
            $table->string('active');
            $table->foreignId('clients_id')->nullable();
            $table->foreign('clients_id')->references('id')->on('clients');
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
        Schema::dropIfExists('client_partners');
    }
}
