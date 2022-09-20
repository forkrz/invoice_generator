<?php

use Illuminate\Database\Schema\Blueprint;
use WouterJ\EloquentBundle\Facade\Schema;

Class createClients extends \App\Service\Migrations
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->integer('NIP');
            $table->string('COMPANY_NAME');
            $table->string('STREET');
            $table->string('ZIP_CODE');
            $table->string('CITY');
            $table->string('EMAIL');
            $table->integer('USER_ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
