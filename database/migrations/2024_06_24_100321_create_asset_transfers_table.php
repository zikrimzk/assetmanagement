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
        Schema::create('asset_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('trans_description');
            $table->date('trans_date');
            $table->integer('trans_status')->default(1);
            $table->integer('new_dep');
            $table->integer('new_area');
            $table->foreignId('asset_id')->constrained('assets');
            $table->foreignId('transferby')->constrained('staffs');
            $table->foreignId('approvedby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_transfers');
    }
};
