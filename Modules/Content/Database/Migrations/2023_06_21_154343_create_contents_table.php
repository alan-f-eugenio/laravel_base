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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_nav_id')->constrained('content_navs')->cascadeOnDelete();
            $table->foreignId('create_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('update_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->datetimes();
            $table->softDeletes();
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('title');
            $table->string('slug');
            $table->string('subtitle')->nullable();
            $table->string('author')->nullable();
            $table->text('text')->nullable();
            $table->mediumText('abstract')->nullable();
            $table->string('link')->nullable();
            $table->string('page_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('filename')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('contents');
    }
};
