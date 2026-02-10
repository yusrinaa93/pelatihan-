<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('pelatihan') && !Schema::hasColumn('pelatihan', 'image_path')) {
            Schema::table('pelatihan', function (Blueprint $table) {
                $table->string('image_path')->nullable()->after('title');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pelatihan') && Schema::hasColumn('pelatihan', 'image_path')) {
            Schema::table('pelatihan', function (Blueprint $table) {
                $table->dropColumn('image_path');
            });
        }
    }
};


