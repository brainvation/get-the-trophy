<?php

// phpcs:disable PSR1.Classes.ClassDeclaration -- would break Laravel Migration

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitionGameRoundDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_game_round_data', function (Blueprint $table) {
            $table->foreignId('competition_game_round_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('key')
                ->comment('Key of data/setting');
            $table->text('value')
                ->comment('Value of data/setting');
            $table->primary([
                'competition_game_round_id',
                'key',
            ], 'competition_game_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competition_game_round_data');
    }
}
