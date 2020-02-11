<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Evaluate extends Model
{
    protected $table = "evaluates";
    public $timestamps = false; 
    
    public $incrementing = false;
    protected $primaryKey = ['StudentId', 'ClassId'];
    
    protected $fillable = [
        'StudentId',
        'ClassId',
        'Understand',
        'Punctuality',
        'Support',
        'Teaching'
    ];

    protected function setKeysForSaveQuery(Builder $query)
    {
        return $query->where('StudentId', $this->getAttribute('StudentId'))
                        ->where('ClassId', $this->getAttribute('ClassId'));
    }

    public function student()
    {
        return $this->belongsTo('App\Model\Student', 'StudentId', 'StudentId');
    }
}
