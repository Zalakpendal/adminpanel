<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category\categorylist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create category', ['only' => ['addcategoryform','insertdata']]);
        $this->middleware('permission:update category', ['only' => ['updatedata', 'editform']]);
        $this->middleware('permission:delete category', ['only' => ['destroy']]);
        $this->middleware('permission:view category', ['only' => ['listingpage']]);
    }
    public function listingpage()
    {
        $data = categorylist::sortable()->paginate(3);
        return view('admin.category.categorylisting',compact('data'));
    }
  
    public function addcategoryform()
    {
        return view('admin.category.addcategory');
    }
    public function insertdata(Request $request)
    {
        $request->validate([
            'categoryName' => 'required',
            'image'=> 'required'
        ]);

        $existingCategory = categorylist::where('categoryname', $request->categoryName)->first();
        if ($existingCategory) {
            return redirect()->route('admin.categories.list')->with('error', 'Category already exists!');
        }    

        $data = new categorylist;
        $data->categoryname = $request->categoryName;
        $data->status = 1;

        if ($request->file('image')) {
            $filePath = 'categoryimages';
            $path = Storage::disk('public')->put($filePath, $request->image);
            $data->image = $path;
            $data->save();
            return redirect()->route('admin.categories.list')->with('success', 'Category added!');
        }
        
    }

    public function destroy($id)
    {
        $data = categorylist::find($id);
        $data->delete();
        return redirect()->route('admin.categories.list');
    }

    public function editform($id)
    {
        $data = categorylist::find($id);
        return view('admin/Category/editcategory',compact('data','id'));
    }

    public function updatedata(Request $request,$id)
    {
        $request->validate([
            'categoryName' => 'required',
            'image' => 'required'
        ]);
    
        $existingCategory = categorylist::where('categoryname', $request->categoryName)->where('id', '!=', $id)->first();
        if ($existingCategory) {
            return redirect()->route('admin.categories.list', $id)->with('error', 'Category already exists!');
        }
        $data = categorylist::find($id);
        $data->categoryname = $request->categoryName;
        if ($request->file('image')) {
            $filePath = 'categoryimages';
            $path = Storage::disk('public')->put($filePath, $request->image);
            $data->image = $path;
        }

        $data->save();
        return redirect()->route('admin.categories.list')->with('success','Data Updated Successfully!!!!');
    }
      public function toggleStatus($id)
    {
        $category = categorylist::find($id);
        if ($category) {
            $category->status = ($category->status == 1) ? 0 : 1;
            $category->save();

            return redirect()->route('admin.categories.list')->with('success', 'Status updated successfully!');
        }

        return redirect()->route('admin.categories.list')->with('error', 'Category not found!');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        $data = categorylist::where('categoryname', 'LIKE', "%{$search}%")->paginate(3);

        return view('admin.category.categorylisting', compact('data'));
    }

}
