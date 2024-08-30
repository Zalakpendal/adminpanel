<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'roles',
        'role_name',
    ];
    public $table = 'admins';

    // Specify the guard if using a custom guard
    protected $guard = 'admin';


//     public function roles()
// {
//     return $this->belongsToMany(Role::class,);
// }
}

