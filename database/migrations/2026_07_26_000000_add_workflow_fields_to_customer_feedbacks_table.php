<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customer_feedbacks', function (Blueprint $table) {
            $table->string('ref_number')->nullable()->unique()->after('id');
            $table->string('status')->default('New')->after('suggestions');
            $table->date('date_closed')->nullable()->after('status');
            $table->string('investigation_undertaken')->nullable()->after('date_closed');
            $table->text('investigation_record')->nullable()->after('investigation_undertaken');
            $table->text('investigation_findings')->nullable()->after('investigation_record');
            $table->text('investigation_actions')->nullable()->after('investigation_findings');
            $table->text('complainant_feedback')->nullable()->after('investigation_actions');
            $table->text('improvement_action_required')->nullable()->after('complainant_feedback');
            $table->text('organisational_improvement_actions')->nullable()->after('improvement_action_required');
            $table->string('improvement_implemented')->nullable()->after('organisational_improvement_actions');
            $table->text('manager_note')->nullable()->after('improvement_implemented');
        });
    }

    public function down(): void
    {
        Schema::table('customer_feedbacks', function (Blueprint $table) {
            $table->dropColumn([
                'ref_number',
                'status',
                'date_closed',
                'investigation_undertaken',
                'investigation_record',
                'investigation_findings',
                'investigation_actions',
                'complainant_feedback',
                'improvement_action_required',
                'organisational_improvement_actions',
                'improvement_implemented',
                'manager_note',
            ]);
        });
    }
};
