<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cves', function (Blueprint $table) {
            $table->increments('id');
            $table->char('cve_id',20);
            $table->char('cve_status',10);
            $table->text('cve_description');
            $table->text('cve_references');
            $table->text('cve_phase');
            $table->text('cve_votes');
            $table->text('cve_comments');
            $table->index('cve_id');
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
        Schema::drop('cve');
    }
}
