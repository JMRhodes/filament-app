<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'tournaments', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'name' );
            $table->date( 'started_at' );
            $table->date( 'ended_at' );
            $table->text( 'photo' )->nullable()->change();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'tournaments' );
    }
};
