<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('update_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->datetimes();
            $table->string('type');
            $table->string('integration');
            $table->unsignedTinyInteger('status')->default(2);
            $table->json('defines')->nullable();
            $table->unsignedTinyInteger('editable')->default(1);
        });
    }

    public function down(): void {
        Schema::dropIfExists('integrations');
    }
};
