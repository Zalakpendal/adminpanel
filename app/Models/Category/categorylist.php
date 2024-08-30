<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class categorylist extends Model
{
    use HasFactory,Sortable,SoftDeletes;

    public function getImageAttribute($value)
    {
        if (!empty($this->attributes['image'])) {
            return Storage::disk('public')->url($this->attributes['image']);
        }
    }

    public $sortable = [
        'categoryname'
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
