<?php

// phpcs:disable PSR1.Classes.ClassDeclaration -- Namespace would break Laravel Migration

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()
                ->comment('Display Name of user');
            $table->string('external_service')
                ->comment('Name of Service the user connects from (Telegram, Facebook etc.)');
            $table->string('external_id')
                ->comment('User ID provided by the external service (only one, 
                        otherwise we would not know where to send the notification');
            $table->boolean('privacy_consent')
                ->comment('Flag if privacy consent is given');
            $table->unique(['external_service', 'external_id'], 'users_external_id');
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
        Schema::dropIfExists('users');
    }
}
