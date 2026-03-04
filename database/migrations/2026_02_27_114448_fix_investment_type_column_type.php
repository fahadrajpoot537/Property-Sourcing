<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE available_properties MODIFY COLUMN investment_type VARCHAR(255) NULL");
        DB::statement("ALTER TABLE available_properties MODIFY COLUMN financing_type VARCHAR(255) NULL");
        DB::statement("ALTER TABLE available_properties MODIFY COLUMN tenure_type VARCHAR(255) NULL");
        DB::statement("ALTER TABLE available_properties MODIFY COLUMN completion_deadline VARCHAR(255) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to revert specifically for this fix
    }
};
