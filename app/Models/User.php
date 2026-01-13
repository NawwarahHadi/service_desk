<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Contracts\LaratrustUser as LaratrustUserContract;
use Laratrust\Traits\HasRolesAndPermissions;

class User extends Authenticatable implements LaratrustUserContract
{
    use HasFactory, Notifiable, HasRolesAndPermissions;

    protected $table = 'users';

    // 1. REMOVED 'userid' from this list
    protected $fillable = [
        'name',
        'email',
        'student_id',
        'password',
        'is_active',
        'phone_num',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // 2. REMOVED the boot() function completely.
    // Laravel will now automatically use the default 'id' column as the primary key.

    public function categories()
    {
        return $this->belongsToMany(
            \App\Models\Category::class,
            'technician_categories',
            'user_id',
            'category_id'
        );
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_technician_id');
    }
}
