<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationUsbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_usb', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reservation_id')->unsigned();
            $table->foreign("reservation_id")->references("id")->on("reservations");
            $table->integer('usb_id')->unsigned();
            $table->foreign("usb_id")->references("id")->on("usbs");
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
        Schema::table('reservation_usb', function (Blueprint $table) {
            $table->dropForeign('reservation_id');
            $table->dropForeign('usb_id');
        });
        Schema::dropIfExists('reservation_usb');
    }
}
