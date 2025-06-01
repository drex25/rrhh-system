<?php

namespace App\Policies;

use App\Models\Payslip;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PayslipPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Admin', 'HR']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Payslip $payslip): bool
    {
        if ($user->hasRole(['Admin', 'HR'])) {
            return true;
        }

        return $user->employee && $user->employee->id === $payslip->employee_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(['Admin', 'HR']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Payslip $payslip): bool
    {
        return $user->hasRole(['Admin', 'HR']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Payslip $payslip): bool
    {
        return $user->hasRole(['Admin', 'HR']);
    }

    /**
     * Determine whether the user can manage payslips.
     */
    public function manage(User $user): bool
    {
        return $user->hasRole(['Admin', 'HR']);
    }
} 