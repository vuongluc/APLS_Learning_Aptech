<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class Enroll extends Model
{
    protected $table = "enrolls";
    public $timestamps = false; 
    
    public $incrementing = false;
    protected $primaryKey = ['StudentId', 'ClassId'];
    
    protected $fillable = [
        'StudentId',
        'ClassId',
        'Passed',
        'Hw1Grade',
        'Hw2Grade',
        'Hw3Grade',
        'Hw4Grade',
        'Hw5Grade',
        'ExamGrade'
    ];

    protected function setKeysForSaveQuery(Builder $query)
    {
        return $query->where('StudentId', $this->getAttribute('StudentId'))
                        ->where('ClassId', $this->getAttribute('ClassId'));
    }
}
