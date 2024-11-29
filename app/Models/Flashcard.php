<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'front_content',
        'back_content',
        'share_content',
        'category_id',
    ];

    protected $table = 'flashcards';

    //Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    //Relasi dengan Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
