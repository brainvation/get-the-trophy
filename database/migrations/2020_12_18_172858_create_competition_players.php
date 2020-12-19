<?php

// phpcs:disable PSR1.Classes.ClassDeclaration -- would break Laravel Migration

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitionUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_users', function (Blueprint $table) {
            $table->foreignId('competition_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_id')
                ->index()
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->char('role', 2)
                ->comment('Role in competition - (P)layer, (A)dmin, (L)eft...');
            $table->primary(['competition_id', 'user_id'], 'competition_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competition_players');
    }
}
