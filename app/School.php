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
        'name', 'about', 'medium', 'code', 'theme',
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
