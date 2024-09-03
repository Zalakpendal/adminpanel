<?php

namespace App\Http\Controllers\RestaurantType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RestaurantType\typelist;

class RestaueanrtypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create restauranttype', ['only' => ['addrestauranttypeform','create']]);
        $this->middleware('permission:update restauranttype', ['only' => ['updatedata', 'editform']]);
        $this->middleware('permission:delete restauranttype', ['only' => ['destory']]);
        $this->middleware('permission:view restauranttype', ['only' => ['listingpage']]);
    }
    public function addrestauranttypeform(Request $request)
    {
        $request->validate([
            'restaurant_type' => 'required'
        ]);
        $exists = typelist::where('restauranttype', $request->restaurant_type)->exists();

        if ($exists) {
            return redirect()->route('admin.restaurant.list')->with('error', 'RestaurantType already exists!');
        }

        $data = new typelist; 
        $data->restauranttype=$request->restaurant_type;
        $data->save();
        return redirect()->route('admin.restaurant.list')->with('success', 'RestaurantType Added Successfully!');
    }

    public function create()
    {
        return view('admin.Restauranttypemodule.add');
    }
    public function listingpage()
    {
        $data = typelist::sortable()->paginate(5);
        return view('admin.Restauranttypemodule.Restaurantlist',compact('data'));
    }
    public function destroy($id)
    {
        
        $data = typelist::find($id);
        $data->delete();
        return redirect()->route('admin.restaurant.list')->with('success', 'RestaurantType deleted Successfully!!!!');
    }
    
    public function editform($id)
    {
        $data = typelist::find($id);
        return view('admin/Restauranttypemodule/editdataform',compact('data','id'));
    }

    public function updatedata(Request $request,$id)
    {
        $data = typelist::find($id);
        $data->restauranttype=$request->restaurant_type;
        $data->save();
        return redirect()->route('admin.restaurant.list')->with('success','Data Updated Successfully!!!!');
    }
    public function toggleStatus($id)
    {
        $type = typelist::find($id);
        if ($type) {
            // Toggle the status between 'active' and 'inactive'
            $type->status = ($type->status === 'active') ? 'inactive' : 'active';
            $type->save();
            
            return redirect()->route('admin.restaurant.list')->with('success', 'Status updated successfully!');
        }
        
        return redirect()->route('admin.restaurant.list')->with('error', 'Restaurant type not found!');
    }
    public function search(Request $request)
    {
        $search = $request->input('search');

        $data = typelist::where('restauranttype', 'LIKE', "%{$search}%")->paginate(5);

        return view('admin.Restauranttypemodule.Restaurantlist', compact('data'));
    }

   


}


