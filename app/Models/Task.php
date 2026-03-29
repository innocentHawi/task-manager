<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'due_date',
        'priority',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    // Priority order for sorting
    public static array $priorityOrder = [
        'high'   => 1,
        'medium' => 2,
        'low'    => 3,
    ];

    // Status progression order
    public static array $statusOrder = [
        'pending'     => 1,
        'in_progress' => 2,
        'done'        => 3,
    ];
}