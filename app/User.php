<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, Impersonate;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'address', 'nationality', 'code',/* school code*/
        'student_code', 'active', 'gender', 'verified', 'school_id', 'section_id','advance_amount','blood_group'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeStudent($q)
    {
        return $q->where('role', 'student');
    }

    public function scopeGuardian($q)
    {
        return $q->where('role', 'guardian');
    }

    public function scopeActive($q)
    {
        return $q->where('active', 1);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function studentInfo()
    {
        return $this->hasOne(StudentInfo::class, 'user_id');
    }

    public function studentBoardExam()
    {
        return $this->hasMany(StudentBoardExam::class, 'student_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'student_id');
    }

    public function hasRole(string $role): bool
    {
        return $this->role == $role ? true : false;
    }

    public function adminDepartments()
    {
        return $this->belongsToMany(Department::class, 'department_user')->withTimestamps();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
    public function feeTranscation()
    {
        return $this->hasMany(FeeTransaction::class,'student_id');
    }
    public function staffAttendances()
    {
        return $this->hasMany(StuffAttendance::class, 'stuff_id', 'id');
    }
}
