<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Kyslik\ColumnSortable\Sortable;

class menulist extends Model
{
    use HasFactory, Sortable;

    protected $fillable = [
        'restaurant_id', 'category_id', 'itemname', 'price', 'description', 'image', 'status'
    ];

    public function getImageAttribute($value)
    {
        if (!empty($this->attributes['image'])) {
            return Storage::disk('public')->url($this->attributes['image']);
        }
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category\categorylist', 'category_id');
    }

    public $sortable = [
         'itemname', 'price'
    ];
}
