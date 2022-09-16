<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use WouterJ\EloquentBundle\Facade\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices_total', function (Blueprint $table) {
            $table->id();
            $table->string('NAME');
            $table->integer('USER_ID');
            $table->integer('USER_NIP');
            $table->string('USER_NAME');
            $table->string('USER_STREET');
            $table->string('USER_ZIP_CODE');
            $table->string('USER_CITY');
            $table->string('USER_EMAIL');
            $table->integer('CLIENT_ID')->nullable();
            $table->integer('CLIENT_NIP');
            $table->string('CLIENT_NAME');
            $table->string('CLIENT_STREET');
            $table->string('CLIENT_ZIP_CODE');
            $table->string('CLIENT_CITY');
            $table->string('CLIENT_EMAIL');
            $table->date('DATE_OF_ISSUE');
            $table->date('PAY_BY');
            $table->date('REALISED_ON');
            $table->float('NET_VALUE');
            $table->float('VAT_VALUE');
            $table->float('GROSS_VALUE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices_total');
    }
};
