<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('family');
            $table->integer('age')->nullable();
            $table->string('state')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('national_id')->unique();
            $table->string('telegram_phone')->unique()->nullable();
            $table->string('telegram_id')->unique()->nullable();
            $table->string('static_ip')->nullable();

            $table->enum('work_status', [
                'temporary_employment',
                'permanent_employment ',
                'dismissal',
                'suspension',
                'contract',
                'contractor',
            ])->nullable();

            $table->enum('position', [
                'manager',
                'cashier',
                'order_recipient',
                'preparation',
                'waiter'
            ])->nullable();

            $table->foreignId('company_id')->nullable()->constrained('companies');

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
