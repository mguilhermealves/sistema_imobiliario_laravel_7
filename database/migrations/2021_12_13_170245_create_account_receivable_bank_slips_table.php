<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountReceivableBankSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_receivable_bank_slips', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->nullable()->default(NULL);
            $table->string('link')->nullable()->default(NULL);
            $table->string('pdf')->nullable()->default(NULL);
            $table->string('expire_at')->nullable()->default(NULL);
            $table->string('charge_id')->nullable()->default(NULL);
            $table->string('status')->nullable()->default(NULL);
            $table->string('total')->nullable()->default(NULL);
            $table->string('payment')->nullable()->default(NULL);
            $table->string('active');
            $table->foreignId('account_receivables_id')->nullable();
            $table->foreign('account_receivables_id')->references('id')->on('account_receivables');
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
        Schema::dropIfExists('account_receivable_bank_slips');
    }
}
