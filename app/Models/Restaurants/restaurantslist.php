<?php

namespace App\Models\Restaurants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Kyslik\ColumnSortable\Sortable; 

class restaurantslist extends Model
{
    use HasFactory,Sortable;

    public function getImageAttribute($value)
    {
        if (!empty($this->attributes['image'])) {
            return Storage::disk('public')->url($this->attributes['image']);
        }
    }
    public $sortable = ['restaurantname'];
}
