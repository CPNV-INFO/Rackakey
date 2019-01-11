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
        Schema::create('reservation_usb_table', function (Blueprint $table) {
            $table->increments('id');
            $table->foreign("reservation_id")->references("id")->on("reservations");
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("file_id")->references("id")->on("files");
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
        Schema::dropIfExists('reservation_usb_table');
    }
}
