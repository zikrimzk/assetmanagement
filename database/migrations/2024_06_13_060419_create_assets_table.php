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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_code')->unique();
            $table->double('asset_cost')->default(0)->nullable();
            $table->double('asset_marketval')->default(0)->nullable();
            $table->string('asset_brand')->nullable();
            $table->string('asset_serialno')->nullable();
            $table->string('asset_remarks')->nullable();
            $table->date('asset_date');
            $table->integer('asset_status');
            $table->string('asset_qrlink')->nullable();
            $table->string('asset_image')->nullable();
            $table->foreignId('comp_id')->constrained('companies');
            $table->foreignId('dep_id')->constrained('departments');
            $table->foreignId('area_id')->constrained('areas');
            $table->foreignId('item_id');
            $table->foreignId('staff_id')->constrained('staffs');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
