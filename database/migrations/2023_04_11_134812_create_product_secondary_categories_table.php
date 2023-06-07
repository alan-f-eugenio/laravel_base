<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('product_secondary_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('products')->cascadeOnDelete();
            $table->foreignId('product_category_id')->nullable()->constrained('product_categories')->cascadeOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('product_secondary_categories');
    }
};
