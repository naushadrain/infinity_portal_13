<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('medication', 'completed')) {
            return;
        }

        Schema::table('medication', function (Blueprint $table) {
            $table->boolean('completed')->default(false)->after('manager_note');
        });
    }

    public function down(): void
    {
        Schema::table('medication', function (Blueprint $table) {
            $table->dropColumn('completed');
        });
    }
};
