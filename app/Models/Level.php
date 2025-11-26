<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // 🔗 Un niveau possède plusieurs cours en ligne
    public function onlineCourses()
    {
        return $this->hasMany(OnlineCourse::class);
    }
}

