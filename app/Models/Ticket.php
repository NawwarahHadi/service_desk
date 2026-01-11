<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;


class Ticket extends Model
{
    protected $table = 'tickets';
    public $timestamps = true;

    protected $fillable = [
        'ticket_number',
        'user_id',
        'category_id',
        'assigned_technician_id',
        'title',
        'description',
        'location',
        'status',
        'raised_date',
        'resolved_date',
        'technician_comment',
    ];

    protected $casts = [
        'raised_date' => 'date',
        'resolved_date' => 'datetime',
    ];

    // Ticket owner (student)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Ticket category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // ✅ Assigned technician (User)
    public function technician()
    {
        return $this->belongsTo(User::class, 'assigned_technician_id');
    }
}
