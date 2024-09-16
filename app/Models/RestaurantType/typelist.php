<?php

namespace App\Models\RestaurantType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable; 
use Illuminate\Database\Eloquent\SoftDeletes;

class typelist extends Model
{
    use HasFactory,Sortable,SoftDeletes;

    public $sortable = ['restauranttype'];
    public static function boot()
    {
        parent::boot();
 
        static::creating(function ($data) {
            $data->created_by = auth()->user()->id;
        });
        static::updating(function ($data) {
            $data->updated_by = auth()->user()->id;
        });
 
        static::deleting(function ($data) {
            $data->deleted_by = auth()->user()->id;
            $data->save();
        });
    }

}


