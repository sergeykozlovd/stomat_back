<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Advert;
use App\Models\Pref;
use App\Models\Category;
use App\Models\Purchase;
use App\RouteName;
use Faker\Guesser\Name;
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

        $alertResult = true;
        $alertTitle = 'Внимание!';
        $alertText = 'Выбранные категории успешно удалены';
        $categoriesForDelete = $request->input('check', []);

        //TODO make delete section
//        $sections = Category::whereIn('id', $categoriesForDelete)->where('parent_id', null)->pluck('id');
//
//        if ($sections->count() > 0){
//            $categoryInSection = Category::whereIn('parent_id', $sections);
//
//            if ($categoryInSection->count() > 0){
//                return dd('dele');
////                return  redirect()->back()->with(
////                    'alert',[
////                    'success' => false ,
////                    'title' => $alertTitle,
////                    'text' => 'Выбранные разделы содержат категории!',
////                ]);
//            }
//        }


        $categoryInAdverts = Advert::whereIn('category_id', $categoriesForDelete)->pluck('category_id');

        if ($categoryInAdverts->isNotEmpty()) {
            $alertResult = false;
            $alertText = 'Не удалось удалить категории принадлежащие объявлениям!' ;

            $categoryNames = Category::whereIn('id',$categoryInAdverts)->pluck('name');
            foreach ($categoryNames as $name){
                $alertText .= " $name" ;
            }
        } else {
            Category::whereIn('id', $categoriesForDelete)->delete();
        }
        return redirect()->back()->with(
            'alert',[
            'success' => $alertResult,
            'title' => $alertTitle,
            'text' => $alertText,
        ]);
    }

    public function change(Request $request)
    {
        unset($this->fieldsForValidate['image']);
        $validatedData = $request->validate($this->fieldsForValidate);

        $category = Category::find($request['id']);
        $category->name = $validatedData['name'];

        $category->save();

        Pref::updateOrCreate(
            ['key' => Constants::advert_last_update]
        );

        return $this->show();
    }

    public function apiGetCategories(Request $request)
    {
        return response()->json([
            'categories' => Category::where('parent_id', '=', $request->parent_id)->get()
        ]);
    }
}
