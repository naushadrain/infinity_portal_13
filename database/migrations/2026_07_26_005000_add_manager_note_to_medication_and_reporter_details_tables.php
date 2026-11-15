<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = ['medication', 'reporter_details'];

    public function up(): void
    {
        foreach ($this->tables as $name) {
            if (Schema::hasColumn($name, 'manager_note')) {
                continue;
            }

            Schema::table($name, function (Blueprint $table) {
                $table->text('manager_note')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $name) {
            if (Schema::hasColumn($name, 'manager_note')) {
                Schema::table($name, function (Blueprint $table) {
                    $table->dropColumn('manager_note');
                });
            }
        }
    }
};
