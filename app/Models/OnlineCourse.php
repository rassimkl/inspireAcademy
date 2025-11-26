<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_id',
        'level_id',
        'title',
        'description',
        'file_path',
        'created_by'
    ];

    // 🔗 Un cours appartient à une langue
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    // 🔗 Un cours appartient à un niveau
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    // 🔗 Un cours a été créé par un utilisateur (admin)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

