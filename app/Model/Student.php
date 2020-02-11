<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = "students";
    public $timestamps = false; 
     /**
     * The primary key for the model.
     *
     * @var string
     */
    public $incrementing = false;
    //$timestamps = false;
    protected $primaryKey = 'StudentId';
    
    protected $fillable = [
        'StudentId',
        'FirstName',
        'LastName',
        'BirthDate',
        'Contact',
        'StatusId'
    ];

    public function classes()
    {
        return $this->belongsToMany('App\Model\Classes', 'evaluates', 'StudentId', 'ClassId');
    }

}
