<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('investors', function (Blueprint $table) {
            $table->boolean('is_cash_buy')->default(false)->after('budget');
            $table->json('deals_of_interest')->nullable()->after('is_cash_buy');
            $table->json('property_types')->nullable()->after('deals_of_interest');
            $table->integer('min_bedrooms')->nullable()->after('property_types');
            $table->integer('max_bedrooms')->nullable()->after('min_bedrooms');
            $table->integer('min_bathrooms')->nullable()->after('max_bedrooms');
            $table->integer('max_bathrooms')->nullable()->after('min_bathrooms');
            $table->json('areas_of_interest')->nullable()->after('max_bathrooms');
            $table->string('address')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('investors', function (Blueprint $table) {
            $table->dropColumn([
                'is_cash_buy',
                'deals_of_interest',
                'property_types',
                'min_bedrooms',
                'max_bedrooms',
                'min_bathrooms',
                'max_bathrooms',
                'areas_of_interest',
                'address'
            ]);
        });
    }
};
