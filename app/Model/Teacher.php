<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = "teachers";
    public $timestamps = false; 
     /**
     * The primary key for the model.
     *
     * @var string
     */
    public $incrementing = false;
    //$timestamps = false;
    protected $primaryKey = 'TeacherId';
    
    protected $fillable = [
        'TeacherId',
        'FirstName',
        'LastName',
        'BirthDate',
        'Contact',
        'StatusId'
    ];

    public function classes(){
        return $this->hasMany('App\Model\Classes', 'TeacherId', 'TeacherId');
    }
}
