<?php

namespace App\Models\Offer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable; 
use Illuminate\Database\Eloquent\SoftDeletes;

class offerlist extends Model
{
    use HasFactory,Sortable,SoftDeletes;

    protected $fillable = [
        'restaurant_id', 'offername', 'coupon_no', 'coupon_validity', 'coupon_time', 'amount', 'minimum_price', 'start_date', 'end_date', 'status'
    ];
    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurants\restaurantslist', 'restaurant_id');
    }
    public $sortable = [
        'restaurant_id', 
        'offername', 
        'coupon_validity', 
        'coupon_time', 
        'amount', 
        'minimum_price',
        'status'
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
