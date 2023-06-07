<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('content_navs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('create_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('update_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->datetimes();
            $table->softDeletes();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedTinyInteger('type')->default(1);
            $table->string('title');
            $table->string('slug');
        });
    }

    public function down(): void {
        Schema::dropIfExists('content_navs');
    }
};
