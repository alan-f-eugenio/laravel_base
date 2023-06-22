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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('create_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('update_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->datetimes();
            $table->softDeletes();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedTinyInteger('ordem');
            $table->string('name');
            $table->string('slug');
            $table->text('text')->nullable();
            $table->string('page_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('filename')->nullable();
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->foreignId('id_parent')->nullable()->after('id')->constrained('product_categories')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::disableForeignKeyConstraints('product_categories');
        Schema::dropIfExists('product_categories');
    }
};
