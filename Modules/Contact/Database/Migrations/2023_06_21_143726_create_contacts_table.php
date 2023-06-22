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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('update_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->datetimes();
            $table->softDeletesDatetime();
            $table->unsignedTinyInteger('seen')->default(0);
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('subject');
            $table->text('message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('contacts');
    }
};
