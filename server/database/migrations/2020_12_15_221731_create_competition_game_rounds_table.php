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
            $table->bigInteger('competition_id', false, true);
            $table->smallInteger('competition_game_sequence_no', false, true);
            $table->smallInteger('sequence_no', false, true)
                ->comment('Sequence in game');
            $table->char('state', 1)
                ->comment('State of competition: (I)nitial, (C)reated, (W)aiting, (A)ctive, (D)one');
            $table->json('config')
                ->comment('Configuration of round');
            $table->json('result_data')
                ->comment('Additional Data for Result etc.');
            $table->timestamps();
            $table->primary(
                ['competition_id', 'competition_game_sequence_no', 'sequence_no'],
                'competition_game_rounds'
            );
            $table->foreign(['competition_id', 'competition_game_sequence_no'], 'competition_game_fk')
                ->references(['competition_id', 'sequence_no'])
                ->on('competition_games')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
