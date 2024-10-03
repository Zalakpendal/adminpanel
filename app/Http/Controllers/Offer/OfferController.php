<?php

namespace App\Http\Controllers\Offer;

use App\Http\Controllers\Controller;
use App\Models\Offer\offerlist;
use App\Models\Restaurants\restaurantslist;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create offer', ['only' => ['addoffers', 'store']]);
        $this->middleware('permission:update offer', ['only' => ['update', 'editform']]);
        $this->middleware('permission:delete offer', ['only' => ['delete']]);
        $this->middleware('permission:view offer', ['only' => ['listingpage']]);
    }
    public function listingpage()
    {
        $currentUser = Auth::user();
        $restaurantId = $currentUser->restaurants;

        if ($restaurantId) {
            $offers = offerlist::where('restaurant_id', $restaurantId)
                ->sortable()
                ->with('restaurant')
                ->paginate(5);
        } else {
            $offers = offerlist::sortable()->with('restaurant')->paginate(5);
        }

        return view('admin.offer.offer', compact('offers'));
    }
    public function addoffers()
    {
        $currentUser = Auth::user();
        $restaurantId = $currentUser->restaurants;

        if ($restaurantId) {
            $restaurants = restaurantslist::where('id', $restaurantId)->pluck('restaurantname', 'id');
        } else {
            $restaurants = restaurantslist::where('status', '1')->pluck('restaurantname', 'id');
        }

        return view('admin.offer.addoffers', compact('restaurants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required',
            'offer_name' => 'required',
            'coupon_no' => 'required',
            'coupon_validity' => 'required',
            'coupon_time' => 'required',
            'amount' => 'required',
            'minimum_price' => 'required|numeric|min:1|max:9999', // Ensures it's numeric and between 1 and 9999
        ]);


        $data = new offerlist;
        $data->restaurant_id = $request->restaurant_id;
        $data->offername = $request->offer_name;
        $data->coupon_no = $request->coupon_no;
        $data->start_date = $request->start_date;
        $data->coupon_validity = $request->coupon_validity;
        $data->coupon_time = $request->coupon_time;
        $data->amount = $request->amount;
        $data->minimum_price = $request->minimum_price;
        $data->status = 1;

        if ($data->save()) {
            return redirect()->route('admin.offersofrestaurants.list')->with('success', 'Offer added successfully!');
        }
    }

    public function changeStatus($offer_id)
    {
        $offer = offerlist::find($offer_id);
        $offer->status = ($offer->status == 1) ? 0 : 1;
        $offer->save();

        return redirect()->route('admin.offersofrestaurants.list')->with('success', 'Offer status changed successfully!');
    }
    public function delete($offer_id)
    {
        $offer = offerlist::find($offer_id);
        $offer->delete();

        return redirect()->route('admin.offersofrestaurants.list')->with('success', 'Offer deleted successfully!');
    }
    public function editform($offer_id)
    {
        $offer = offerlist::findOrFail($offer_id);
        $currentUser = Auth::user();
        $userRestaurantId = $currentUser->restaurants;
        if ($offer->restaurant_id != $userRestaurantId) {
            return redirect()->route('admin.offersofrestaurants.list')->with('error', 'Unauthorized or offer not found.');
        }
        $restaurants = restaurantslist::where('id', $userRestaurantId)->pluck('restaurantname', 'id');

        return view('admin.offer.editoffers', compact('offer', 'restaurants'));
    }

    public function update(Request $request, $offer_id)
    {
        $request->validate([
            'restaurant_id' => 'required',
            'offer_name' => 'required',
            'coupon_no' => 'required',
            'coupon_validity' => 'required',
            'coupon_time' => 'required',
            'amount' => 'required',
            'minimum_price' => 'required',
        ]);

        $offer = offerlist::findOrFail($offer_id);
        $offer->restaurant_id = $request->restaurant_id;
        $offer->offername = $request->offer_name;
        $offer->coupon_no = $request->coupon_no;
        $offer->start_date = $request->start_date;
        $offer->coupon_validity = $request->coupon_validity;
        $offer->coupon_time = $request->coupon_time;
        $offer->amount = $request->amount;
        $offer->minimum_price = $request->minimum_price;

        if ($offer->save()) {
            return redirect()->route('admin.offersofrestaurants.list')->with('success', 'Offer updated successfully!');
        }
    }
    public function searchOffers(Request $request)
    {
        $search = $request->input('search');
        $currentUser = Auth::user();
        $restaurantId = $currentUser->restaurants;

        $offers = offerlist::query()
            ->when($restaurantId, function ($query) use ($restaurantId) {
                return $query->where('restaurant_id', $restaurantId);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('offername', 'like', "%{$search}%")
                        ->orWhere('amount', 'like', "%{$search}%")
                        ->orWhere('minimum_price', 'like', "%{$search}%")
                        ->orWhere('coupon_validity', 'like', "%{$search}%")
                        ->orWhere('coupon_time', 'like', "%{$search}%")
                        ->orWhereHas('restaurant', function ($q) use ($search) {
                            $q->where('restaurantname', 'like', "%{$search}%");
                        });
                });
            })
            ->with('restaurant')
            ->paginate(5);

        return view('admin.offer.offer', compact('offers'));
    }



}
