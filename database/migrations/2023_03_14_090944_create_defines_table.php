<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('defines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('update_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->datetimes();
            $table->string('page_title');
            $table->string('page_meta_keywords')->nullable();
            $table->string('page_meta_description')->nullable();
            $table->string('company_name');
            $table->string('company_corporate_name');
            $table->string('company_cnpj')->nullable();
            $table->string('company_email');
            $table->string('company_phone')->nullable();
            $table->string('company_whats')->nullable();
            $table->string('company_face')->nullable();
            $table->string('company_insta')->nullable();
            $table->string('company_yout')->nullable();
            $table->mediumText('company_cep');
            $table->mediumText('company_address')->nullable();
            $table->mediumText('company_opening_hours')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('defines');
    }
};
