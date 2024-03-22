<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'teams_players', function ( Blueprint $table ) {
            $table->unsignedBigInteger( 'team_id' );
            $table->unsignedBigInteger( 'player_id' );
            $table->timestamps();
            $table->foreign( 'team_id' )->references( 'id' )->on( 'teams' );
            $table->foreign( 'player_id' )->references( 'id' )->on( 'players' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'teams_players' );
    }
};
