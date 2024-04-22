<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sync_events', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->unsignedBigInteger('sync_id');

            $table->primary(['id', 'sync_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sync_events');
    }
};
