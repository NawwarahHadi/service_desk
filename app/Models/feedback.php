<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class feedback extends Model
{
    protected $table = 'feedback';
    protected $fillable = [
        'ticket_id',
        'user_id',
        'title',
        'rating',
        'comment'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
