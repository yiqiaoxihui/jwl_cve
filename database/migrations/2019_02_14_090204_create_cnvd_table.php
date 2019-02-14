<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCnvdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cnvds', function (Blueprint $table) {
            $table->increments('id');
            $table->char('cnvd_id',20);
            $table->char('cnvd_serverity',10);
            $table->text('cnvd_title');
            $table->text('cnvd_products');
            $table->text('cnvd_formalWay');
            $table->text('cnvd_description');
            $table->text('cnvd_patch');
            $table->text('cnvd_submitTime');
            $table->index('cnvd_id');
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
        Schema::drop('cnvd');
    }
}

