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
        Schema::create('company_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('payment_number')->unique();
            $table->string('transaction_id')->nullable();
            $table->string('reference_id')->nullable();
            $table->string('authority')->nullable();
            $table->string('tracking_code')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
            $table->text('gateway_response')->nullable();
            $table->string('gateway_status')->nullable();
            $table->text('failure_reason')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('payment_number');
            $table->index('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_payments');
    }
};
