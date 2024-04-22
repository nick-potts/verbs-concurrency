<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('syncs', function (Blueprint $table) {
            $table->id();
            $table->integer('count');
            $table->text('order');
            $table->integer('actual_count');
            $table->integer('requested_count');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('syncs');
    }
};
