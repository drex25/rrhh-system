<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Crear permisos
        $permissions = [
            // Empleados
            'view_employees',
            'create_employees',
            'edit_employees',
            'delete_employees',
            
            // Departamentos
            'view_departments',
            'create_departments',
            'edit_departments',
            'delete_departments',
            
            // Posiciones
            'view_positions',
            'create_positions',
            'edit_positions',
            'delete_positions',
            
            // Recibos
            'view_payslips',
            'create_payslips',
            'edit_payslips',
            'delete_payslips',
            'download_payslips',
            
            // Licencias
            'view_leave_requests',
            'create_leave_requests',
            'edit_leave_requests',
            'delete_leave_requests',
            'approve_leave_requests',
            
            // Tipos de Licencia
            'view_leave_types',
            'create_leave_types',
            'edit_leave_types',
            'delete_leave_types',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Crear roles y asignar permisos
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->givePermissionTo($permissions);

        $hr = Role::firstOrCreate(['name' => 'HR']);
        $hr->givePermissionTo([
            'view_employees', 'create_employees', 'edit_employees',
            'view_departments', 'create_departments', 'edit_departments',
            'view_positions', 'create_positions', 'edit_positions',
            'view_payslips', 'create_payslips', 'edit_payslips', 'download_payslips',
            'view_leave_requests', 'create_leave_requests', 'edit_leave_requests', 'approve_leave_requests',
            'view_leave_types', 'create_leave_types', 'edit_leave_types',
        ]);

        $manager = Role::firstOrCreate(['name' => 'Manager']);
        $manager->givePermissionTo([
            'view_employees',
            'view_departments',
            'view_positions',
            'view_payslips', 'download_payslips',
            'view_leave_requests', 'create_leave_requests', 'edit_leave_requests', 'approve_leave_requests',
            'view_leave_types',
        ]);

        $employee = Role::firstOrCreate(['name' => 'Employee']);
        $employee->givePermissionTo([
            'view_payslips', 'download_payslips',
            'view_leave_requests', 'create_leave_requests',
            'view_leave_types',
        ]);
    }
} 