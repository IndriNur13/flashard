<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_name',
    ];

    protected $table = 'categories';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function flashcards()
    {
        return $this->hasMany(Flashcard::class);
    }
}
