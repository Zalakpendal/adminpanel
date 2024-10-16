<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu\menulist;
use App\Models\Restaurants\restaurantslist;
use App\Models\Category\categorylist;
use Illuminate\Support\Facades\Storage;


class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create menu', ['only' => ['addmenuform', 'insertmenu']]);
        $this->middleware('permission:update menu', ['only' => ['updateform', 'editform']]);
        $this->middleware('permission:delete menu', ['only' => ['deletemenu']]);
        $this->middleware('permission:view menu', ['only' => ['showmenu']]);
    }
    public function showmenu($id)
    {
        $restaurant = restaurantslist::where('id', $id)->first();
        $menuItems = menulist::sortable()->where('restaurant_id', $id)->with('category')->paginate(5);
        return view('admin.menu.menulisting', compact('restaurant', 'menuItems'));
    }

    public function addmenuform($id)
    {
        $categories = categorylist::where('status', '1')->pluck('categoryname', 'id');
        $restaurant = restaurantslist::where('id', $id)->first();
        return view('admin.menu.addmenu', compact('categories', 'restaurant'));
    }

    public function insertmenu(Request $request, $id)
    {
        $request->validate([
            'restaurant_id' => 'required',
            'category_id' => 'required',
            'item_name' => 'required',
            'item_price' => 'required|numeric',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg'
        ]);

        $existingRestaurantItem = menulist::where('itemname', $request->item_name)
            ->where('restaurant_id', $request->restaurant_id)
            ->first();

            if ($existingRestaurantItem) {
                return redirect()->route('admin.menuofrestaurants.add', ['id' => $id])
                    ->withErrors(['item_name' => 'This item already exists in the menu.']) 
                    ->withInput();
            }

        $data = new menulist;
        $data->restaurant_id = $request->restaurant_id;
        $data->category_id = $request->category_id;
        $data->itemname = $request->item_name;
        $data->price = $request->item_price;
        $data->description = $request->description;
        $data->status = 1;

        if ($request->file('image')) {
            $filePath = 'menuitemsimages';
            $path = Storage::disk('public')->put($filePath, $request->image);
            $data->image = $path;
        }

        $data->save();
        return redirect()->route('admin.menuofrestaurants.list', ['id' => $id])
            ->with('success', 'Item added to the menu!');
    }

    public function deletemenu($restaurant_id, $menu_id)
    {
        $menu = menulist::where('restaurant_id', $restaurant_id)->where('id', $menu_id)->first();
        $menu->delete();
        return redirect()->route('admin.menuofrestaurants.list', ['id' => $restaurant_id])->with('success', 'item deleted to the menu');
    }

    public function editform($restaurant_id, $menu_id)
    {
        $menuItem = menulist::find($menu_id);
        $categories = categorylist::pluck('categoryname', 'id');
        $restaurant = restaurantslist::find($restaurant_id);

        return view('admin.menu.editmenu', compact('menuItem', 'categories', 'restaurant'));
    }

    // public function updateform(Request $request, $restaurant_id, $menu_id)
    // {
    //     $menuItem = menulist::find($menu_id);
    //     $menuItem->category_id = $request->category_id;
    //     $menuItem->itemname = $request->item_name;
    //     $menuItem->price = $request->item_price;
    //     $menuItem->description = $request->description;


    //     $menuItem->save();
    //     return redirect()->route('admin.menuofrestaurants.list', ['id' => $restaurant_id])->with('success', 'updated successfully');

    // }
    public function updateform(Request $request, $restaurant_id, $menu_id)
    {
        $request->validate([
            'category_id' => 'required',
            'item_name' => 'required',
            'item_price' => 'required|numeric',
            'description' => 'required',
        ]);
        $menuItem = menulist::find($menu_id);
        
        $existingItem = menulist::where('itemname', $request->item_name)
            ->where('restaurant_id', $restaurant_id)
            ->where('id', '!=', $menu_id) 
            ->first();
    
        if ($existingItem) {
            return redirect()->back()
                ->withErrors(['item_name' => 'This item already exists in the menu.']) 
                ->withInput(); 
        }
    
        $menuItem->category_id = $request->category_id;
        $menuItem->itemname = $request->item_name;
        $menuItem->price = $request->item_price;
        $menuItem->description = $request->description;
    
        $menuItem->save();
        
        return redirect()->route('admin.menuofrestaurants.list', ['id' => $restaurant_id])
            ->with('success', 'Updated successfully');
    }
    
    public function toggleStatus($restaurant_id, $menu_id)
    {
        $menuItem = menulist::find($menu_id);
        $menuItem->status = ($menuItem->status == 1) ? 0 : 1;
        $menuItem->save();

        return redirect()->route('admin.menuofrestaurants.list', ['id' => $restaurant_id])->with('success', 'Status updated successfully.');
    }

    public function search(Request $request, $restaurant_id)
    {
        $search = $request->input('search');
        $query = menulist::where('restaurant_id', $restaurant_id);
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('itemname', 'LIKE', "%{$search}%")
                    ->orWhere('price', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('categoryname', 'LIKE', "%{$search}%");
                    });
                if(strtolower($search)=='active'){
                    $query->orWhere('status',1);
                }
                elseif(strtolower($search)=='inactive'){
                    $query->orWhere('status',0);
                }
            });
        }
        $menuItems = $query->with('category')->paginate(5);
        $restaurant = restaurantslist::find($restaurant_id);
        return view('admin.menu.menulisting', compact('restaurant', 'menuItems'));
    }
}
