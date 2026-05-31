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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('menu_id')->constrained('menus');
            $table->foreignId('printer_id')->constrained('printers');
            $table->string('name');
            $table->string('name_en')->nullable();
            $table->integer('price');
            $table->boolean('active')->default(true);
            $table->string('description')->nullable();
            $table->string('description_en')->nullable();
            $table->boolean('show_customer')->default(true);
            $table->boolean('show_order_recipient')->default(true);
            $table->string('image')->nullable();
            $table->string('rost_time')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
