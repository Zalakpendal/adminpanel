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
    public function addrestaurantform()
    {
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
            'image' => 'required|image|mimes:jpeg,png,jpg'

        ]);

        $existingRestaurant = restaurantslist::where('restaurantname', $request->restaurantName)->orWhere('email', $request->email)->first();

        if ($existingRestaurant) {

            return redirect()->route('admin.allrestaurants.list')->with('error', 'Restaurant already exists.')->withInput();
        }
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
            return redirect()->route('admin.allrestaurants.list')->with('success', 'successfully added!');
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
        $restaurantTypes = typelist::where('status', '1')->pluck('restauranttype', 'id');
        $data = restaurantslist::find($id);
        return view('admin/Restaurants/editform', compact('data', 'id', 'restaurantTypes'));
    }

    // public function updatedata(Request $request, $id)
    // {
    //     $data = restaurantslist::find($id);
    //     $data->restaurantname = $request->restaurantName;
    //     $data->email = $request->email;
    //     $data->restauranttype = $request->restaurantType;
    //     $data->phonenumber = $request->phoneNumber;
    //     $data->address = $request->address;
    //     $data->discription = $request->description;
    //     $data->save();
    //     return redirect()->route('admin.allrestaurants.list')->with('success', 'Data Updated Successfully!!!!');
    // }
    public function updatedata(Request $request, $id)
    {
        $request->validate([
            'restaurantName' => 'required',
            'email' => 'required|email',
            'restaurantType' => 'required',
            'phoneNumber' => 'required',
            'address' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        $data = restaurantslist::find($id);
        if (!$data) {
            return redirect()->route('admin.allrestaurants.list')->with('error', 'Restaurant not found.');
        }
        $existingRestaurant = restaurantslist::where(function ($query) use ($request, $id) {
            $query->where('restaurantname', $request->restaurantName)
                ->orWhere('email', $request->email);
        })->where('id', '!=', $id)
            ->first();

        if ($existingRestaurant) {
            return redirect()->back()->with('error', 'Restaurant with the same name or email already exists.')->withInput();
        }
        $data->restaurantname = $request->restaurantName;
        $data->email = $request->email;
        $data->restauranttype = $request->restaurantType;
        $data->phonenumber = $request->phoneNumber;
        $data->address = $request->address;
        $data->discription = $request->description;


        if ($request->file('image')) {

            $filePath = 'restaurantimages';
            $path = Storage::disk('public')->put($filePath, $request->image);
            $data->image = $path;
        }

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
    public function listingpage(Request $request)
    {
        $currentUser = Auth::user();
        $restaurantId = $currentUser->restaurants;
        $allRestaurants = restaurantslist::all();

        if ($request->has('restaurant_id') && $request->restaurant_id != '') {
            $data = restaurantslist::where('id', $request->restaurant_id)->sortable()->paginate(3);
        } elseif ($restaurantId) {
            $data = restaurantslist::where('id', $restaurantId)->sortable()->paginate(3);
        } else {
            $data = restaurantslist::sortable()->paginate(3);
        }

        return view('admin.Restaurants.allrestaurantlist', compact('data', 'allRestaurants'));
    }
}
