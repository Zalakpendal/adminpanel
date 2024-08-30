<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurants\restaurantslist;
use Exception;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
{
    public function getRestaurant()
    {
        try{
        $restaurants = restaurantslist::all();
        // dd($restaurants);
        $result = array('status'=>true,'message'=> count($restaurants).'user(s) fetched','data'=> $restaurants);
        $responseCode = 200;//for the 200 http request code meaning is success.
        return response()->json($result,$responseCode);
        }
        catch(Exception $e)
        {
            $result = array('status'=>false,'message'=>"API failed due to an error",
            "error"=>$e->getMessage());
            return response()->json($result,500);
        }   
    }
}
