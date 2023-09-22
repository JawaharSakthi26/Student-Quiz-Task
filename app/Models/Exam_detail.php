<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam_detail extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id','question_id','answer'
    ];

    public function users() {
        return $this->belongsTo(User::class);
    }

    public function questions() {
        return $this->belongsTo(Question::class);
    }
}
