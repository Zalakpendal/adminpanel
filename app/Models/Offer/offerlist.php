<?php

namespace App\Models\Offer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable; 

class offerlist extends Model
{
    use HasFactory,Sortable;
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
}
