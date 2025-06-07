<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('candidates', function (Blueprint $table) {
            // Eliminar SOLO columnas que realmente existen y no son usadas ni por el formulario público ni por el modelo
            // Por seguridad, aquí no eliminamos ninguna columna automáticamente
            // Si necesitas eliminar alguna columna específica, hazlo manualmente tras verificar que no se usa

            // Agregar nuevas columnas si no existen
            if (!Schema::hasColumn('candidates', 'name')) {
                $table->string('name')->nullable()->after('job_posting_id');
            }
            if (!Schema::hasColumn('candidates', 'notes')) {
                $table->text('notes')->nullable()->after('status');
            }
            if (!Schema::hasColumn('candidates', 'interview_date')) {
                $table->dateTime('interview_date')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('candidates', 'interview_type')) {
                $table->string('interview_type')->nullable()->after('interview_date');
            }
            if (!Schema::hasColumn('candidates', 'interview_location')) {
                $table->string('interview_location')->nullable()->after('interview_type');
            }
            if (!Schema::hasColumn('candidates', 'interview_notes')) {
                $table->text('interview_notes')->nullable()->after('interview_location');
            }
            if (!Schema::hasColumn('candidates', 'technical_test_path')) {
                $table->string('technical_test_path')->nullable()->after('interview_notes');
            }
            if (!Schema::hasColumn('candidates', 'technical_test_score')) {
                $table->integer('technical_test_score')->nullable()->after('technical_test_path');
            }
            if (!Schema::hasColumn('candidates', 'reference_check_notes')) {
                $table->text('reference_check_notes')->nullable()->after('technical_test_score');
            }
            if (!Schema::hasColumn('candidates', 'preoccupational_test_date')) {
                $table->dateTime('preoccupational_test_date')->nullable()->after('reference_check_notes');
            }
            if (!Schema::hasColumn('candidates', 'preoccupational_test_location')) {
                $table->string('preoccupational_test_location')->nullable()->after('preoccupational_test_date');
            }
            if (!Schema::hasColumn('candidates', 'offer_details')) {
                $table->text('offer_details')->nullable()->after('preoccupational_test_location');
            }
            if (!Schema::hasColumn('candidates', 'offer_accepted_at')) {
                $table->dateTime('offer_accepted_at')->nullable()->after('offer_details');
            }
            if (!Schema::hasColumn('candidates', 'hired_at')) {
                $table->dateTime('hired_at')->nullable()->after('offer_accepted_at');
            }
            if (!Schema::hasColumn('candidates', 'withdrawn_reason')) {
                $table->text('withdrawn_reason')->nullable()->after('rejection_reason');
            }
            if (!Schema::hasColumn('candidates', 'calendly_link')) {
                $table->string('calendly_link')->nullable()->after('withdrawn_reason');
            }
            if (!Schema::hasColumn('candidates', 'meet_link')) {
                $table->string('meet_link')->nullable()->after('calendly_link');
            }
            if (!Schema::hasColumn('candidates', 'interviewer_name')) {
                $table->string('interviewer_name')->nullable()->after('meet_link');
            }
        });
    }

    public function down()
    {
        Schema::table('candidates', function (Blueprint $table) {
            // Restaurar columnas eliminadas
            $table->text('cover_letter')->nullable();
            $table->json('interview_schedule')->nullable();
            $table->decimal('expected_salary', 10, 2)->nullable();
            $table->string('current_position')->nullable();
            $table->string('current_company')->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->string('education_level')->nullable();
            $table->string('source')->nullable();
            $table->boolean('is_active')->default(true);

            // Eliminar nuevas columnas
            $table->dropColumn([
                'name',
                'notes',
                'interview_date',
                'interview_type',
                'interview_location',
                'interview_notes',
                'technical_test_path',
                'technical_test_score',
                'reference_check_notes',
                'preoccupational_test_date',
                'preoccupational_test_location',
                'offer_details',
                'offer_accepted_at',
                'hired_at',
                'withdrawn_reason',
                'calendly_link',
                'meet_link',
                'interviewer_name'
            ]);
        });
    }
}; 