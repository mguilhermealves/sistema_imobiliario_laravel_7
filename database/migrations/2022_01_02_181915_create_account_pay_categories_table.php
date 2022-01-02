<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountPayCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_pay_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_category')->nullable()->default(NULL);
            $table->string('type_category')->nullable()->default(NULL);
            $table->integer('cost_center_category')->unique()->nullable()->default(NULL);
            $table->enum('active', ['1', '0'])->nullable()->default('1');
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
        Schema::dropIfExists('account_pay_categories');
    }
}
