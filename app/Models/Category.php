<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'category_id');
    }

    public function technicians()
    {
        return $this->belongsToMany(
            \App\Models\User::class,
            'technician_categories',
            'category_id',
            'user_id'
        );
    }
}
