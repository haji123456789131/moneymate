<?php

// app/Models/SavingGoal.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavingGoal extends Model
{
    protected $fillable = ['user_id', 'title', 'target_amount', 'current_amount', 'deadline'];

    // Casts date agar mudah diformat di Blade
    protected $casts = [
        'deadline' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}