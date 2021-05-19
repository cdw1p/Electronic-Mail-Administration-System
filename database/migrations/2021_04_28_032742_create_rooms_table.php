<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id('id_rooms');
            $table->string('name');
            $table->string('start_date');
            $table->string('end_date');
            $table->bigInteger('is_recording');
            $table->bigInteger('is_start_meeting');
            $table->bigInteger('is_join_before_host');
            $table->string('zoom_id');
            $table->string('zoom_link');
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
        Schema::dropIfExists('rooms');
    }
}
