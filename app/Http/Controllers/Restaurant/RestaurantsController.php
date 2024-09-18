<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\Restaurants\restaurantslist;
use App\Models\RestaurantType\typelist;
use Illuminate\Support\Facades\Storage;

class RestaurantsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create restaurant', ['only' => ['addrestaurantform', 'insertdataofrestaurant']]);
        $this->middleware('permission:update restaurant', ['only' => ['updatedata', 'editform']]);
        $this->middleware('permission:delete restaurant', ['only' => ['destroy']]);
        $this->middleware('permission:view restaurant', ['only' => ['listingpage']]);
    }
    // public function listingpage()
    // {
    //     $data = restaurantslist::sortable()->paginate(3);
    //     //return view ma blade file no path aapvaano 6e 
    //     return view('admin.Restaurants.allrestaurantlist', compact('data'));
    // }
    public function listingpage()
    {
        $currentUser = Auth::user();
        $restaurantId = $currentUser->restaurants;

        if ($restaurantId) {
            $data = restaurantslist::where('id', $restaurantId)->sortable()->paginate(3);
        } else {
            $data = restaurantslist::sortable()->paginate(3);
        }

        return view('admin.Restaurants.allrestaurantlist', compact('data'));
    }

    public function addrestaurantform()
    {
        // $restaurantTypes = typelist::pluck('restauranttype', 'id');
        $restaurantTypes = typelist::where('status', '1')->pluck('restauranttype', 'id');
        return view('admin.Restaurants.addrestaurant', compact('restaurantTypes'));
    }

    public function insertdataofrestaurant(Request $request)
    {
        $request->validate([
            'restaurantName' => 'required',
            'email' => 'required',
            'restaurantType' => 'required',
            'phoneNumber' => 'required',
            'address' => 'required',
            'description' => 'required',
            'image' => 'required'

        ]);

        $existingRestaurant = restaurantslist::where('restaurantname', $request->restaurantName)->orWhere('email', $request->email)->first();

        if ($existingRestaurant) {

            return redirect()->route('admin.allrestaurants.list')->with('error', 'Restaurant already exists.');
        }

        // If restaurant does not exist, proceed with insertion
        $data = new restaurantslist;
        $data->restaurantname = $request->restaurantName;
        $data->email = $request->email;
        $data->restauranttype = $request->restaurantType;
        $data->phonenumber = $request->phoneNumber;
        $data->address = $request->address;
        $data->status = 'inactive';
        $data->discription = $request->description;

        if ($request->file('image')) {
            $filePath = 'restaurantimages';
            $path = Storage::disk('public')->put($filePath, $request->image);
            $data->image = $path;
        }

        if ($data->save()) {
            return redirect()->route('admin.allrestaurants.list')->with('success','successfully added!');
        }
    }

    public function destroy($id)
    {
        $restaurant = restaurantslist::find($id);
        if (!$restaurant) {
            return redirect()->route('admin.allrestaurants.list')->with('error', 'Restaurant not found.');
        }

        $restaurant->delete();

        return redirect()->route('admin.allrestaurants.list')->with('success', 'Restaurant deleted successfully.');
    }


    public function editform($id)
    {
        $data = restaurantslist::find($id);
        return view('admin/Restaurants/editform', compact('data', 'id'));
    }

    public function updatedata(Request $request, $id)
    {
        $data = restaurantslist::find($id);
        $data->restaurantname = $request->restaurantName;
        $data->email = $request->email;
        $data->restauranttype = $request->restaurantType;
        $data->phonenumber = $request->phoneNumber;
        $data->address = $request->address;
        $data->discription = $request->description;
        $data->save();
        return redirect()->route('admin.allrestaurants.list')->with('success', 'Data Updated Successfully!!!!');
    }

    public function toggleStatus($id)
    {
        $restaurant = restaurantslist::find($id);        
        $restaurant->status = ($restaurant->status == 1) ? 0 : 1;
        $restaurant->save();

        return redirect()->route('admin.allrestaurants.list')->with('success', 'Status updated successfully.');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $data = restaurantslist::where('restaurantname', 'LIKE', "%{$search}%")->paginate(3);
        return view('admin.Restaurants.allrestaurantlist', compact('data'));
    }

}
