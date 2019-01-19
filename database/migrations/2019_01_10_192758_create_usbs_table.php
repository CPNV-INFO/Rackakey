<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usbs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('uuid');
            $table->unsignedBigInteger('freeSpaceInBytes');
            $table->integer('status_id')->unsigned();
            $table->integer('rack_number');
            $table->integer('port_number');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('usbs', function (Blueprint $table) {
            $table->dropForeign('status_id');
        });
        Schema::dropIfExists('usbs');
    }
}
