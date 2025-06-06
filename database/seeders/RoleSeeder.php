<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $hr = Role::firstOrCreate(['name' => 'HR']);
        $manager = Role::firstOrCreate(['name' => 'Manager']);
        $employee = Role::firstOrCreate(['name' => 'Employee']);
        $interviewer = Role::firstOrCreate(['name' => 'Interviewer']);

        // Crear permisos
        $permissions = [
            // Permisos generales
            'view_dashboard',
            'view_profile',
            'edit_profile',

            // Permisos de reclutamiento
            'view_job_postings',
            'create_job_postings',
            'edit_job_postings',
            'delete_job_postings',
            'view_candidates',
            'create_candidates',
            'edit_candidates',
            'delete_candidates',
            'view_interviews',
            'create_interviews',
            'edit_interviews',
            'delete_interviews',
            'complete_interviews',
            'cancel_interviews',
            'reschedule_interviews',

            // Permisos de empleados
            'view_employees',
            'create_employees',
            'edit_employees',
            'delete_employees',

            // Permisos de departamentos
            'view_departments',
            'create_departments',
            'edit_departments',
            'delete_departments',

            // Permisos de posiciones
            'view_positions',
            'create_positions',
            'edit_positions',
            'delete_positions',

            // Permisos de documentos
            'view_documents',
            'create_documents',
            'edit_documents',
            'delete_documents',

            // Permisos de historial académico
            'view_academic_history',
            'create_academic_history',
            'edit_academic_history',
            'delete_academic_history',

            // Permisos de horas extras
            'view_overtime',
            'create_overtime',
            'edit_overtime',
            'delete_overtime',

            // Permisos de capacitaciones
            'view_trainings',
            'create_trainings',
            'edit_trainings',
            'delete_trainings',

            // Permisos de desempeño
            'view_performance',
            'create_performance',
            'edit_performance',
            'delete_performance',

            // Permisos de reportes
            'view_reports',
            'create_reports',
            'edit_reports',
            'delete_reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Asignar todos los permisos al rol Admin
        $admin->givePermissionTo($permissions);

        // Asignar permisos específicos al rol HR
        $hr->givePermissionTo([
            'view_dashboard',
            'view_profile',
            'edit_profile',
            'view_job_postings',
            'create_job_postings',
            'edit_job_postings',
            'view_candidates',
            'create_candidates',
            'edit_candidates',
            'view_interviews',
            'create_interviews',
            'edit_interviews',
            'complete_interviews',
            'cancel_interviews',
            'reschedule_interviews',
            'view_employees',
            'create_employees',
            'edit_employees',
            'view_departments',
            'view_positions',
            'view_documents',
            'view_academic_history',
            'view_overtime',
            'view_trainings',
            'view_performance',
            'view_reports',
        ]);

        // Asignar permisos específicos al rol Manager
        $manager->givePermissionTo([
            'view_dashboard',
            'view_profile',
            'edit_profile',
            'view_employees',
            'view_departments',
            'view_positions',
            'view_documents',
            'view_academic_history',
            'view_overtime',
            'view_trainings',
            'view_performance',
            'view_reports',
        ]);

        // Asignar permisos específicos al rol Employee
        $employee->givePermissionTo([
            'view_dashboard',
            'view_profile',
            'edit_profile',
            'view_documents',
            'view_academic_history',
            'view_overtime',
            'view_trainings',
            'view_performance',
        ]);

        // Asignar permisos específicos al rol Interviewer
        $interviewer->givePermissionTo([
            'view_dashboard',
            'view_profile',
            'edit_profile',
            'view_interviews',
            'complete_interviews',
            'cancel_interviews',
            'reschedule_interviews',
        ]);
    }
} 