<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Anchor the model directly to prevent naming mismatches
    protected $table = 'tasks';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'position',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
