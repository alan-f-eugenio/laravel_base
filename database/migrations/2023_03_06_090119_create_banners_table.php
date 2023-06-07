<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('local_id')->constrained('banner_locals')->cascadeOnDelete();
            $table->foreignId('create_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('update_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->datetimes();
            $table->softDeletes();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedTinyInteger('ordem');
            $table->string('title');
            $table->string('link')->nullable();
            $table->string('filename');
        });
    }

    public function down(): void {
        Schema::dropIfExists('banners');
    }
};
