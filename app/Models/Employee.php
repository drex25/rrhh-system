<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Employee
 *
 * @property int $id
 * @property int $user_id
 * @property string $file_number
 * @property string $first_name
 * @property string $last_name
 * @property string $dni
 * @property string $cuit
 * @property \Illuminate\Support\Carbon $birth_date
 * @property string $birth_country
 * @property string $birth_province
 * @property string $birth_city
 * @property string $nationality
 * @property string|null $gender
 * @property string $address
 * @property string $phone
 * @property string $email
 * @property int $department_id
 * @property int $position_id
 * @property \Illuminate\Support\Carbon $hire_date
 * @property string $employment_type
 * @property \Illuminate\Support\Carbon $work_schedule_from
 * @property \Illuminate\Support\Carbon $work_schedule_to
 * @property string $social_security_number
 * @property string $health_insurance
 * @property string $union
 * @property string $base_salary
 * @property string $bank_account
 * @property string $bank_name
 * @property string $emergency_contact_name
 * @property string $emergency_contact_phone
 * @property string $profile_photo
 * @property string $notes
 * @property bool $is_active
 * @property string $mother_name
 * @property string $father_name
 * @property string $spouse_name
 * @property string $children
 * @property string $cbu_attachment
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Department $department
 * @property-read \App\Models\Position $position
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Payslip[] $payslips
 * @property-read int|null $payslips_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LeaveRequest[] $leaveRequests
 * @property-read int|null $leave_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EmployeeLeaveBalance[] $leaveBalances
 * @property-read int|null $leave_balances_count
 * @property-read \App\Models\Department|null $managedDepartment
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCbuAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereChildren($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCuit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDni($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmploymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmergencyContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmergencyContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereFileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereHealthInsurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereHireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereMotherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereProfilePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSocialSecurityNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereSpouseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUnion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereWorkScheduleFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereWorkScheduleTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereMotherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereFatherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereChildren($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCbuAttachment($value)
 * @mixin \Eloquent
 */
class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'file_number',
        'first_name',
        'last_name',
        'dni',
        'cuit',
        'birth_date',
        'birth_country',
        'birth_province',
        'birth_city',
        'nationality',
        'gender',
        'address',
        'phone',
        'email',
        'department_id',
        'position_id',
        'hire_date',
        'employment_type',
        'work_schedule_from',
        'work_schedule_to',
        'social_security_number',
        'health_insurance',
        'union',
        'base_salary',
        'bank_account',
        'bank_name',
        'emergency_contact_name',
        'emergency_contact_phone',
        'profile_photo',
        'notes',
        'is_active',
        'mother_name',
        'father_name',
        'spouse_name',
        'children',
        'cbu_attachment',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'hire_date' => 'date',
        'base_salary' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function payslips()
    {
        return $this->hasMany(Payslip::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function leaveBalances()
    {
        return $this->hasMany(EmployeeLeaveBalance::class);
    }

    public function getLeaveBalance($leaveTypeId, $year = null)
    {
        $year = $year ?? date('Y');
        return $this->leaveBalances()
            ->where('leave_type_id', $leaveTypeId)
            ->where('year', $year)
            ->first();
    }

    public function managedDepartment()
    {
        return $this->hasOne(Department::class, 'manager_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getBirthProvinceNameAttribute()
    {
        $provinces = cache()->remember('georef_provinces', 86400, function () {
            $response = \Illuminate\Support\Facades\Http::get('https://apis.datos.gob.ar/georef/api/provincias', [
                'campos' => 'id,nombre'
            ]);
            if ($response->successful()) {
                $data = $response->json();
                return collect($data['provincias'])->pluck('nombre', 'id')->toArray();
            }
            return [];
        });
        return $provinces[$this->birth_province] ?? $this->birth_province ?? 'No especificada';
    }
}
