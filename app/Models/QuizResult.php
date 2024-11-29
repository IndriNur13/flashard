<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'flashcard_id',
        'is_correct',
        'attempted_at',
    ];

    protected $table = 'quizresults';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function flashcard()
    {
        return $this->belongsTo(Flashcard::class);
    }
}
