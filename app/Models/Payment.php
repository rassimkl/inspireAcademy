<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $casts = [
        'payment_date' => 'date',
    ];

    protected $fillable = ['amount', 'user_id', 'hours', 'payment_date'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
