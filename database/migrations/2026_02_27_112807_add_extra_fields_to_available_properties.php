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
            $table->string('property_title')->nullable()->after('headline');
            $table->string('door_number')->nullable()->after('location');
            $table->string('city')->nullable()->after('door_number');
            $table->string('postcode')->nullable()->after('city');
            $table->decimal('market_value_min', 15, 2)->nullable()->after('price');
            $table->decimal('market_value_max', 15, 2)->nullable()->after('market_value_min');
            $table->decimal('market_value_avg', 15, 2)->nullable()->after('market_value_max');
            $table->decimal('psg_fees', 15, 2)->nullable()->after('market_value_avg');
            $table->decimal('portal_sale_price', 15, 2)->nullable()->after('psg_fees');
            $table->string('exchange_deadline')->nullable()->after('completion_deadline');
            $table->string('assignable_contract')->nullable()->after('exchange_deadline');
            $table->string('share_of_freehold')->nullable()->after('tenure_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('available_properties', function (Blueprint $table) {
            $table->dropColumn([
                'property_title',
                'door_number',
                'city',
                'postcode',
                'market_value_min',
                'market_value_max',
                'market_value_avg',
                'psg_fees',
                'portal_sale_price',
                'exchange_deadline',
                'assignable_contract',
                'share_of_freehold'
            ]);
        });
    }
};
