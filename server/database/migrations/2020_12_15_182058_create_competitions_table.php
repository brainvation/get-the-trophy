<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')
                ->comment('Optional, can be used for identification and in fancy texts/announcements');
            $table->char('state', 1)
                ->comment('State of competition: (I)nitial, (C)reated, (W)aiting, (A)ctive, (D)one');
            $table->string('linked_channel_service')
                ->comment('Links Compettion to a channel / group of a certain service');
            $table->string('linked_channel_id')
                ->comment('ID of linked channel / group');

            /*
            - 1:x users with Pivot Role
            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competitions');
    }
}
