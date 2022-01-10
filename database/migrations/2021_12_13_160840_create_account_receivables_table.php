<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountReceivablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_receivables', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable()->default(NULL);
            $table->string('status_payment')->nullable()->default(NULL);
            $table->decimal('fees', 5, 2)->nullable()->default(NULL);
            $table->decimal('fine', 5, 2)->nullable()->default(NULL);
            $table->decimal('amount', 9, 2)->nullable()->default(NULL);
            $table->string('day_due')->nullable()->default(NULL);
            $table->string('payment_method')->nullable()->default(NULL);
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
        Schema::dropIfExists('account_receivables');
    }
}
