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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_name_id')->constrained('goods')->onDelete('cascade');
            $table->foreignId('city_name_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('report_status_id')->constrained('report_statuses')->onDelete('cascade');
            $table->foreignId('report_type_id')->constrained('report_types')->onDelete('cascade');
            $table->integer('report_in_base');
            $table->timestamp('date_request');
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
