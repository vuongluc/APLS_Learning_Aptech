<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Capable extends Model
{
    protected $table = "capables";
    public $timestamps = false; 
     /**
     * The primary key for the model.
     *
     * @var string
     */
    // public $incrementing = false;
    //$timestamps = false;
    // protected $primaryKey = 'TeacherId';
    
    protected $fillable = [
        'ModuleId',
        'TeacherId'
    ];

}
