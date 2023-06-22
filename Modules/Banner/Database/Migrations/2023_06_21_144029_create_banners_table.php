<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('local_id')->constrained('banner_locals')->cascadeOnDelete();
            $table->foreignId('create_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('update_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->datetimes();
            $table->softDeletesDatetime();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedTinyInteger('ordem');
            $table->string('title');
            $table->string('link')->nullable();
            $table->string('filename');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('banners');
    }
};
