<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
   protected $fillable = [
        'user_id',
        'title',
        'description',
        'completed',
        'priority',
        'task_list_id',
    ];
    protected $casts = [
        'completed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
