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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('create_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('update_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->datetimes();
            $table->softDeletes();
            $table->unsignedTinyInteger('status')->default(1);
            $table->string('token');
            $table->string('description');
            $table->unsignedInteger('qtd')->nullable();
            $table->dateTime('date_start')->nullable();
            $table->dateTime('date_end')->nullable();
            $table->unsignedDecimal('value_min')->nullable();
            $table->unsignedDecimal('value_max')->nullable();
            $table->unsignedDecimal('discount');
            $table->unsignedTinyInteger('discount_type');
            $table->unsignedTinyInteger('first_buy')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('coupons');
    }
};
