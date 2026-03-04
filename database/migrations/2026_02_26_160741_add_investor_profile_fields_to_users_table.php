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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('budget', 15, 2)->nullable()->after('investment_type');
            $table->text('property_interests')->nullable()->after('budget');
            $table->double('latitude')->nullable()->after('property_interests');
            $table->double('longitude')->nullable()->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['budget', 'property_interests', 'latitude', 'longitude']);
        });
    }
};
