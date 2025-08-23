<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $guarded = [];

    // protected $fillable = ['id' , 'name' , 'username' , 'email' , 'password'];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'admin_id');
    }

    public function authorization()
    {
        return $this->belongsTo(Authorization::class, 'role_id');
    }

    public function hasAccess($config_permission)
    {
        $authorization = $this->authorization; // This gets the related model instance

        if (!$authorization) {
            return false;
        }

        // Get permissions and ensure it's an array
        $permissions = $authorization->permissions;
        if (!is_array($permissions)) {
            $permissions = json_decode(json_encode($permissions), true) ?: [];
        }
        
        if (empty($permissions)) {
            return false;
        }

        return in_array($config_permission, $permissions);
    }

    public function receivesBroadcastNotificationsOn(): string
    {
        return 'admins.' . $this->id;
    }
}
