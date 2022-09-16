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
        Schema::create('invoices_products', function (Blueprint $table) {
            $table->id();
            $table->integer('INVOICE_ID');
            $table->integer('PRODUCT_ID')->nullable();
            $table->string('PRODUCT_NAME');
            $table->float('NET_PRICE');
            $table->int('TAX_RATE');
            $table->int('QUANTITY');
            $table->float('NET_VALUE');
            $table->float('TAX_VALUE');
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
        Schema::dropIfExists('invoices_products');
    }
};
