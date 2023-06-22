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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('create_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('update_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('product_category_id')->nullable()->constrained('product_categories')->nullOnDelete();
            $table->foreignId('product_att1_id')->nullable()->constrained('product_attributes')->nullOnDelete();
            $table->foreignId('product_opt1_id')->nullable()->constrained('product_attribute_opts')->nullOnDelete();
            $table->foreignId('product_att2_id')->nullable()->constrained('product_attributes')->nullOnDelete();
            $table->foreignId('product_opt2_id')->nullable()->constrained('product_attribute_opts')->nullOnDelete();
            $table->unsignedTinyInteger('has_child')->default(0);
            $table->unsignedTinyInteger('type')->default(1);
            $table->datetimes();
            $table->softDeletes();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedTinyInteger('ordem')->nullable();
            $table->string('sku');
            $table->string('name');
            $table->string('slug');
            $table->string('ean')->nullable();
            $table->unsignedInteger('stock')->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->unsignedInteger('depth')->nullable();
            $table->unsignedDecimal('weight', 8, 3)->nullable();
            $table->unsignedDecimal('price')->nullable();
            $table->unsignedDecimal('price_cost')->nullable();
            $table->unsignedDecimal('promo_value')->nullable();
            $table->dateTime('promo_date_in')->nullable();
            $table->dateTime('promo_date_end')->nullable();
            $table->string('deadline')->nullable();
            $table->string('warranty')->nullable();
            $table->string('brand')->nullable();
            $table->string('page_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->text('text')->nullable();
            $table->string('filename')->nullable();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('id_parent')->nullable()->after('id')->constrained('products')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::disableForeignKeyConstraints('products');
        Schema::dropIfExists('products');
    }
};
