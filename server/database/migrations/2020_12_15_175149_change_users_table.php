<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_unique');
            $table->string('email')->nullable()->change();
            $table->string('password')->nullable()->change();
            $table->string('external_service')
                ->comment('Name of Service the user connects from (Telegram, Facebook etc.)');
            $table->string('external_id')
                ->comment('User ID provided by the external service (only one, 
                    otherwise we would not know where to send the notification');
            $table->boolean('data_consent');
            $table->unique(['external_service', 'external_id'], 'users_external_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_external_id');
            $table->string('email')->unique()->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
            $table->dropColumn(['external_service', 'external_id', 'data_consent']);
        });
    }
}
