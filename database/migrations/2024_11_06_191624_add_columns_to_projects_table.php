<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // First, create the projects table if it doesn't exist
        if (!Schema::hasTable('projects')) {
            Schema::create('projects', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->string('image_path')->nullable();
                $table->foreignId('category_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        } else {
            // If the table exists, add the columns
            Schema::table('projects', function (Blueprint $table) {
                if (!Schema::hasColumn('projects', 'title')) {
                    $table->string('title');
                }
                if (!Schema::hasColumn('projects', 'description')) {
                    $table->text('description');
                }
                if (!Schema::hasColumn('projects', 'image_path')) {
                    $table->string('image_path')->nullable();
                }
                if (!Schema::hasColumn('projects', 'category_id')) {
                    $table->foreignId('category_id')->constrained()->onDelete('cascade');
                }
                if (!Schema::hasColumn('projects', 'created_at')) {
                    $table->timestamps();
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};