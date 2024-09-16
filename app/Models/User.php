<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use Kyslik\ColumnSortable\Sortable; 

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles, Sortable; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'is_admin',
        'is_user',
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

    public function getImageAttribute($value)
    {
        if (!empty($this->attributes['image'])) {
            return Storage::disk('public')->url($this->attributes['image']);
        }
    }
    public $sortable = ['id','name', 'email'];
    
    
}
