<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('manager_reports', function (Blueprint $table) {
            $table->date('date_of_issue')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('manager_reports', function (Blueprint $table) {
            $table->date('date_of_issue')->nullable(false)->change();
        });
    }
};
