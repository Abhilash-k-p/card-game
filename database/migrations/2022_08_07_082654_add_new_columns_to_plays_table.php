<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plays', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index()->after('id');
            $table->unsignedBigInteger('user_score')->after('user_id');
            $table->unsignedBigInteger('game_score')->after('user_score');
            $table->text('user_hand')->after('game_score');
            $table->text('cpu_hand')->after('user_hand');
            $table->enum('result', ['WON', 'LOST', 'TIE'])->after('cpu_hand');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plays', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'user_score', 'game_score', 'user_hand', 'cpu_hand', 'result']);
        });
    }
};
