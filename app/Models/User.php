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

    protected $fillable = [
        'userid',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->userid)) {
                $lastUser = static::where('userid', 'like', 'STUD%')
                    ->orderByRaw('CAST(SUBSTRING(userid, 5) AS UNSIGNED) DESC')
                    ->first();

                $newNumber = $lastUser
                    ? ((int) substr($lastUser->userid, 5) + 1)
                    : 1;

                $user->userid = 'STUD' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
            }
        });
    }
    // app/Models/User.php

    public function categories()
    {
        return $this->belongsToMany(
            \App\Models\Category::class,
            'technician_categories',
            'user_id',      // ✅ matches your table
            'category_id'
        );
    }

    public function role()
    {
        // This tells Laravel: "My role_id column belongs to the Role model"
        return $this->belongsTo(Role::class, 'role_id');
    }
}
