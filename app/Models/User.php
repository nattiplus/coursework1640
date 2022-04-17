<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function ideas() {
        return $this->hasMany(Idea::class);
    }

    public function viewers() {
        return $this->hasMany(Viewer::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function reactions() {
        return $this->hasMany(Reaction::class);
    }

    public function hasPermission($route)
    {
        return in_array($route, $this->Routes()) ? true : false;
    }

    // Route that user have
    public function Routes()
    {
        $roles = $this->getRoles();
        $data = array();
        foreach($this->roles as $key => $role)
        {
            $permissions = \json_decode($role->permissions);
            foreach($permissions as $permission)
            {
                if(!in_array($permission, $data))
                {
                    array_push($data, $permission);
                }
            }
        }
        return $data;
    }

    public function getRoles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }
}
