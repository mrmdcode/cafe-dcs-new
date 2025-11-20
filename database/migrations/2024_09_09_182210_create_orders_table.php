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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')->nullable()->constrained('tables');
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('order_recipient_id')->constrained('users');
            $table->foreignId('waiter_id')->nullable()->constrained('users');
            $table->foreignId('cashier')->nullable()->constrained('users');
            $table->foreignId('customer_id')->nullable()->constrained('customers');
            $table->enum('status', [
                'registration',
                'cancelled',
                'edit',
                'finish',
                'paid'
            ])->default('registration');
            $table->integer('edit_parent')->nullable();
            $table->string('unique_key');
            $table->string('delete_description')->nullable();
            $table->unsignedInteger('discount')->nullable();
            $table->time('waiter_time')->nullable();
            $table->time('cashier_time')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
