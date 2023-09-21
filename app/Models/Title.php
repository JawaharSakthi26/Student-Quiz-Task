<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use HasFactory;

    protected $fillable=[
        'quiz_title'
    ];

    public function questions() {
        return $this->hasMany(Question::class);
    }

    // public function exams()
    // {
    //     return $this->hasMany(Exam::class);
    // }
}
