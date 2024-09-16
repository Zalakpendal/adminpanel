<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;


class menulist extends Model
{
    use HasFactory, Sortable,SoftDeletes;

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
    protected $guarded = ['created_at,updated_at,deleted_at'];

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
