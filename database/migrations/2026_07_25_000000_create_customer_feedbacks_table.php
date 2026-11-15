<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Live DBs already have this table (created outside migrations); only create it when missing.
        if (Schema::hasTable('customer_feedbacks')) {
            return;
        }

        Schema::create('customer_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('ref_number')->nullable()->unique();
            $table->string('city_name')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->boolean('wants_interpreter')->default(false);
            $table->string('interpreter_language')->nullable();
            $table->boolean('wants_response')->nullable();
            $table->string('preferred_contact_method')->nullable();
            $table->enum('feedback_type', ['compliment', 'complaint', 'comment'])->nullable();
            $table->enum('respondent_type', [
                'participant',
                'family_member',
                'participants_representative',
                'staff_member',
                'staff_on_behalf_of_participant',
                'other',
            ])->nullable();
            $table->string('respondent_type_other')->nullable();
            $table->text('experience')->nullable();
            $table->text('suggestions')->nullable();
            $table->string('status')->default('New');
            $table->date('date_closed')->nullable();
            $table->string('investigation_undertaken')->nullable();
            $table->text('investigation_record')->nullable();
            $table->text('investigation_findings')->nullable();
            $table->text('investigation_actions')->nullable();
            $table->text('complainant_feedback')->nullable();
            $table->text('improvement_action_required')->nullable();
            $table->text('organisational_improvement_actions')->nullable();
            $table->string('improvement_implemented')->nullable();
            $table->text('manager_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_feedbacks');
    }
};
