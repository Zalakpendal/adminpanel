<?php

namespace App\Models\RestaurantType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable; 

class typelist extends Model
{
    use HasFactory,Sortable;

    public $sortable = ['restauranttype'];

}
