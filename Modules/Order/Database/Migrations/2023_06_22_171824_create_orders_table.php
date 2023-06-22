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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->restrictOnDelete();
            $table->foreignId('cart_id')->constrained('carts')->noActionOnDelete();
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->noActionOnDelete();
            $table->foreignId('update_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->datetimes();
            $table->unsignedTinyInteger('status')->default(2);
            $table->string('recipient');
            $table->string('cep');
            $table->string('street');
            $table->string('number');
            $table->string('complement')->nullable();
            $table->string('neighborhood');
            $table->string('city');
            $table->string('state');
            $table->string('shipping_service');
            $table->string('shipping_code');
            $table->string('shipping_value');
            $table->string('payment_service');
            $table->string('coupon')->nullable();
            $table->unsignedDecimal('discount');
            $table->unsignedDecimal('value');
            $table->unsignedTinyInteger('installments');
            $table->string('tid')->nullable();
            $table->string('payment_link')->nullable();
            $table->string('payment_code')->nullable();
            $table->string('payment_expiration')->nullable();
            $table->string('customer_obs')->nullable();
            $table->string('obs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('orders');
    }
};
