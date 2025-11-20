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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); //
            $table->string('username'); //
            $table->string('address'); //
            $table->string('state')->nullable(); //
            $table->string('city')->nullable();//
            $table->string('phone')->nullable(); //
            $table->string('name_boss'); //
            $table->string('phone_boss'); //
            $table->string('phone_representative')->nullable(); //
            $table->integer('capacity'); //
            $table->string('sm_tel'); //
            $table->string('sm_instagram')->nullable(); //
            $table->string('sm_telegram')->nullable(); //
            $table->string('sm_whatsapp')->nullable(); //
            $table->string('sm_twitter')->nullable(); //
            $table->string('sm_threads')->nullable(); //
            $table->string('sm_website')->nullable();//
            $table->string('zip')->nullable(); //
            $table->string('lat')->nullable(); //
            $table->string('long')->nullable();//
            $table->boolean('plan_menu')->default(true); //
            $table->boolean('plan_order_taker')->default(false); //
            $table->boolean('plan_time_report')->default(false); //
            $table->boolean('plan_online_order')->default(false); //
            $table->boolean('plan_printer_control')->default(false); //
            $table->boolean('plan_preparation_notification')->default(false); //
            $table->boolean('active')->default(true);
            $table->integer('fee_received')->comment('Price in Tomans | per month'); //
            $table->string('image')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
