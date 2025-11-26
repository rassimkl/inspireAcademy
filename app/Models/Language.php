<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // 🔗 Une langue possède plusieurs cours en ligne
    public function onlineCourses()
    {
        return $this->hasMany(OnlineCourse::class);
    }
}

