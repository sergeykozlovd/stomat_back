<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Advert;
use App\Models\Pref;
use App\Models\Category;
use App\RouteName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    private $fieldsForValidate = [
        'name' => 'required|max:255|min:3',
        'image' => 'required|image|mimes:png,jpg|max:2048',
    ];

    public function showAddForm()
    {
        return view('category_add',['categories' => Category::where('parent_id',null)->get()]);
    }

    public function showEditForm(Request $request)
    {
        $id = $request['id'];
        return view('category_edit', ['category' => Category::find($id)]);
    }
    public function create(Request $request)
    {
        if (!$request->section){
            unset($this->fieldsForValidate['image']);
        }
        $validatedData = $request->validate($this->fieldsForValidate);
        $category = new Category();
        $category->name = $validatedData['name'];
        if (!$request->section) {
            $category->parent_id = $request->category;
        } else if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('', 'public');
            $category->image = $imagePath;
        }

        $category->save();

        Pref::updateOrCreate(
            ['key' => Constants::advert_last_update]
        );
        return redirect(route(RouteName::CATEGORY_SHOW));
    }

    public function show()
    {
        $categories = Category::where('parent_id','=', null )->get();
        $sorted = [];

        foreach($categories as $category){
            $sorted[] = $category;
            $subcategories =Category::where('parent_id','=', $category->id )->get();
            foreach($subcategories as $subcategory){
                $sorted[] = $subcategory;
            }
        }

        return view('categories', ['categories' => $sorted]);
    }

    public function delete(Request $request)
    {
        $selectedItems = $request->input('check', []);
        foreach ($selectedItems as $itemId) {
            Category::find($itemId)->delete();
        }
        return redirect()->back()->with('success', 'Selected items deleted successfully.');
    }



    public function change(Request $request)
    {
        $validatedData = $request->validate($this->fieldsForValidate);

        $category = Category::find($request['id']);
        $category->name = $validatedData['name'];

        $category->save();

        Pref::updateOrCreate(
            ['key' => Constants::advert_last_update]
        );

        return $this->show();
    }
}
