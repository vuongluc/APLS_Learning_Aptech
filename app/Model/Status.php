<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = "status";
    public $timestamps = false; 
     /**
     * The primary key for the model.
     *
     * @var string
     */
    public $incrementing = false;
    //$timestamps = false;
    protected $primaryKey = 'StatusId';
    protected $fillable = [
        'StatusId',
        'Description',
        'StatusName'
    ];

    public function classes(){
        return $this->hasMany('App\Model\Classes', 'StatusId', 'StatusId');
    }
}
