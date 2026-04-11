<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('inspirations', 'published_at')) {
            Schema::table('inspirations', function (Blueprint $table): void {
                $table->dropColumn('published_at');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('inspirations', 'published_at')) {
            Schema::table('inspirations', function (Blueprint $table): void {
                $table->timestamp('published_at')->nullable()->after('is_featured');
            });
        }
    }
};
