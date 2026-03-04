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
        // Add indexes to properties table
        Schema::table('properties', function (Blueprint $table) {
            $table->index('created_at');
            $table->index('location');
        });

        // Add indexes to services table
        Schema::table('services', function (Blueprint $table) {
            $table->index('slug');
        });

        // Add indexes to locations table
        Schema::table('locations', function (Blueprint $table) {
            $table->index('slug');
            $table->index('parent_id');
        });

        // Add indexes to news table
        Schema::table('news', function (Blueprint $table) {
            $table->index('slug');
            $table->index('created_at');
        });

        // Add indexes to team_members table
        Schema::table('team_members', function (Blueprint $table) {
            $table->index(['category', 'sort_order']);
        });

        // Add indexes to faqs table
        Schema::table('faqs', function (Blueprint $table) {
            $table->index('sort_order');
        });

        // Add indexes to work_steps table
        Schema::table('work_steps', function (Blueprint $table) {
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['location']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['slug']);
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropIndex(['parent_id']);
        });

        Schema::table('news', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->dropIndex(['category', 'sort_order']);
        });

        Schema::table('faqs', function (Blueprint $table) {
            $table->dropIndex(['sort_order']);
        });

        Schema::table('work_steps', function (Blueprint $table) {
            $table->dropIndex(['sort_order']);
        });
    }
};
