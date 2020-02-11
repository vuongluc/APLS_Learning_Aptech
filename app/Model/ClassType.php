<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ClassType extends Model
{
    protected $table = "classtypes";
    public $timestamps = false; 
     /**
     * The primary key for the model.
     *
     * @var string
     */
    public $incrementing = false;
    //$timestamps = false;
    protected $primaryKey = 'TypeId';
    public function classes(){
        return $this->hasMany('App\Model\Classes', 'TypeId', 'TypeId');
    }
}
