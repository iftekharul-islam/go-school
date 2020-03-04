<?php

namespace App;

use App\Events\SchoolCreated;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'about', 'medium', 'code', 'theme','district', 'sms_charge','per_student_charge','invoice_generation_date',
        'email','singup_date','due_date','is_sms_enable', 'absent_msg', 'present_msg'
    ];

    protected $dispatchesEvents = [
      'created' => SchoolCreated::class,
    ];

  public function users()
  {
    return $this->hasMany('App\User');
  }

  public function departments()
  {
    return $this->hasMany('App\Department');
  }

  public function gradesystems()
  {
    return $this->hasMany('App\Gradesystem');
  }
  public function schoolMeta()
  {
    return $this->hasOne('App\SchoolMeta');
  }
}
