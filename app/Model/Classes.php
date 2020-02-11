<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = "classes";
    public $timestamps = false; 
     /**
     * The primary key for the model.
     *
     * @var string
     */
    public $incrementing = false;
    //$timestamps = false;
    protected $primaryKey = 'ClassId';
    
    protected $fillable = [
        'ClassId',
        'TeachingHour',
        'ModuleId',
        'StatusId',
        'TeacherId',
        'TypeId'
    ];

    public function module()
    {
        return $this->belongsTo('App\Model\Module', 'ModuleId', 'ModuleId');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\Status', 'StatusId', 'StatusId');
    }

    public function classtype()
    {
        return $this->belongsTo('App\Model\ClassType', 'TypeId', 'TypeId');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Model\Teacher', 'TeacherId', 'TeacherId');
    }

    public function student()
    {
        return $this->belongsToMany('App\Model\Student', 'evaluates', 'ClassId', 'StudentId');
    }

}
