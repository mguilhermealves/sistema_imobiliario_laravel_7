<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_files', function (Blueprint $table) {
            $table->id();
            $table->string('image_file')->nullable()->default(NULL);
            $table->string('IRPF_file')->nullable()->default(NULL);
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
        Schema::dropIfExists('tenant_files');
    }
}
