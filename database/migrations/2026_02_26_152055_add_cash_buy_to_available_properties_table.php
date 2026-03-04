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
        Schema::table('available_properties', function (Blueprint $table) {
            $table->boolean('is_cash_buy')->default(false)->after('status');
            $table->date('completion_deadline')->nullable()->after('is_cash_buy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('available_properties', function (Blueprint $table) {
            $table->dropColumn(['is_cash_buy', 'completion_deadline']);
        });
    }
};
