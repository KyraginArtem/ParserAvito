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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_name_id')->constrained('goods')->onDelete('cascade');
            $table->foreignId('status_name_id')->constrained('ad_statuses')->onDelete('cascade');
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade');
            $table->foreignId('city_name_id')->constrained('cities')->onDelete('cascade');
            $table->text('title');
            $table->string('link');
            $table->string('price');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
