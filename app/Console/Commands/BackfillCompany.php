<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema; // agregado

class BackfillCompany extends Command
{
    protected $signature = 'tenant:backfill {--company= : Slug o ID de la company a usar} {--dry : Sólo mostrar conteos}';
    protected $description = 'Asigna company_id a registros que están NULL en tablas multi-tenant.';

    private array $tables = [
        'departments', 'employees', 'positions', 'payslips', 'leave_types', 'leave_requests', 'employee_leave_balances',
        'overtimes', 'performances', 'trainings', 'documents', 'interviews', 'job_postings', 'candidates', 'leads',
        'academic_histories', 'attendances'
    ];

    public function handle(): int
    {
        $companyOption = $this->option('company');
        $company = is_numeric($companyOption)
            ? Company::find($companyOption)
            : Company::where('slug', $companyOption)->first();

        if (!$company) {
            $company = Company::first();
            $this->warn('No se encontró company por opción, usando: ' . ($company?->slug ?? 'NINGUNA'));
        }
        if (!$company) {
            $this->error('No hay company disponible. Aborta.');
            return self::FAILURE;
        }

        $dry = $this->option('dry');

        foreach ($this->tables as $table) {
            if (!\Schema::hasTable($table) || !\Schema::hasColumn($table, 'company_id')) {
                $this->line("[skip] {$table} sin tabla o columna company_id");
                continue;
            }
            $count = DB::table($table)->whereNull('company_id')->count();
            if ($count === 0) {
                $this->line("[ok] {$table} sin pendientes");
                continue;
            }
            if ($dry) {
                $this->info("[dry] {$table}: {$count} registros se asignarían");
            } else {
                $updated = DB::table($table)->whereNull('company_id')->update(['company_id' => $company->id]);
                $this->info("[done] {$table}: {$updated} registros actualizados");
            }
        }

        // Users
        if (\Schema::hasTable('users') && \Schema::hasColumn('users','company_id')) {
            $ucount = DB::table('users')->whereNull('company_id')->count();
            if ($ucount) {
                if ($dry) {
                    $this->info("[dry] users: {$ucount} se asignarían");
                } else {
                    DB::table('users')->whereNull('company_id')->update(['company_id' => $company->id]);
                    $this->info("[done] users: {$ucount} registros actualizados");
                }
            }
        }

        return self::SUCCESS;
    }
}
