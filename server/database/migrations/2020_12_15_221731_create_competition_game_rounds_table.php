<?php

// phpcs:disable PSR1.Classes.ClassDeclaration -- will break Laravel Migration

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitionGameRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_game_rounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_game_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->smallInteger('sequence_no', false, true)
                ->comment('Sequence in game');
            $table->char('state', 1)
                ->comment('State of competition: (I)nitial, (C)reated, (W)aiting, (A)ctive, (D)one');
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
        Schema::dropIfExists('competition_game_rounds');
    }
}
