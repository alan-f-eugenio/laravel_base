<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->datetimes();
            $table->softDeletes();
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('create_user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            $table->foreignId('update_user_id')->nullable()->after('create_user_id')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::disableForeignKeyConstraints('users');
        Schema::dropIfExists('users');
    }
};
