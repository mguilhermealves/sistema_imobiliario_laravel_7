<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientPartnerFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_partner_files', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable();
            $table->foreignId('clients_partners_id')->nullable();
            $table->foreign('clients_partners_id')->references('id')->on('client_partners');
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
        Schema::dropIfExists('client_partner_files');
    }
}
