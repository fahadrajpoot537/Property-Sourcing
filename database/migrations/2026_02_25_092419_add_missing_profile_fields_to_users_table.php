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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->after('email');
            $table->string('address_line1')->nullable()->after('phone_number');
            $table->string('address_line2')->nullable()->after('address_line1');
            $table->string('country')->nullable()->after('postcode');
            $table->string('company_registration')->nullable()->after('company_name');
            $table->text('about_me')->nullable()->after('company_registration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone_number',
                'address_line1',
                'address_line2',
                'country',
                'company_registration',
                'about_me'
            ]);
        });
    }
};
