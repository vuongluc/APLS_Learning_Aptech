<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = "modules";
    public $timestamps = false; 
     /**
     * The primary key for the model.
     *
     * @var string
     */
    public $incrementing = false;
    //$timestamps = false;
    protected $primaryKey = 'ModuleId';
    public function classes(){
        return $this->hasMany('App\Model\Classes', 'ModuleId', 'ModuleId');
    }

}
