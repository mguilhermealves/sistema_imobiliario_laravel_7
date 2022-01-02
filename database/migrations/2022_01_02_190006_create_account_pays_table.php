<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountPaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_pays', function (Blueprint $table) {
            $table->id();
            $table->string('company_beneficiary')->nullable()->default(NULL);
            $table->string('amount')->nullable()->default(NULL);
            $table->string('payment_method')->nullable()->default(NULL);
            $table->string('comments')->nullable()->default(NULL);
            $table->string('day_due')->nullable()->default(NULL);
            $table->enum('is_recorrency', ['yes', 'no'])->nullable()->default('no');
            $table->string('status_payment')->nullable()->default(NULL);
            $table->enum('active', ['1', '0'])->nullable()->default('1');
            $table->foreignId('account_category_id')->nullable();
            $table->foreign('account_category_id')->references('id')->on('account_pay_categories');
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
        Schema::dropIfExists('account_pays');
    }
}
