<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDecimalsTableAccountReceivables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_receivables', function (Blueprint $table) {
            $table->decimal('fees', 5, 2)->nullable()->after('payment_method');
            $table->decimal('fine', 5, 2)->nullable()->after('fees');
            $table->decimal('amount', 9, 2)->nullable()->after('fine');
            $table->string('day_due')->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_receivables', function (Blueprint $table) {
            $table->dropColumn('fees');
            $table->dropColumn('fine');
            $table->dropColumn('amount');
            $table->dropColumn('day_due');
        });
    }
}
