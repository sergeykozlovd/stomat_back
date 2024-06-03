<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Advert;
use App\Models\Category;
use App\Models\Pref;
use App\Models\Purchase;
use App\RouteName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdvertController extends Controller
{
    private $fieldsForValidate = [
        'price' => 'nullable|integer',
        'title' => 'required|max:255|min:3',
        'description' => 'required|max:255|min:3',
        'image' => 'required|image|mimes:png,jpg|max:2048', // Max size in kilobytes (2MB)
    ];

    public function showAddForm()
    {
        return view('advert_add', ['categories' => Category::where('parent_id', '!=', null)->get()]);
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate($this->fieldsForValidate);
        $imagePath = $request->file('image')->store('', 'public');
        $advert = new Advert();
        $advert->title = $validatedData['title'];
        $advert->price = $request['price'];
        $advert->category_id = $request['category'];
        $advert->description = $request['description'];
        $advert->image = $imagePath;
        $advert->save();

        Pref::updateOrCreate(
            ['key' => Constants::advert_last_update]
        );

        return redirect(route(RouteName::ADVERT_SHOW_CREATE_FORM));

    }

    public function show()
    {
        $query = DB::table('adverts')
            ->leftJoin('purchases', 'adverts.id', '=', 'purchases.advert_id')
            ->select('adverts.*', 'purchases.state as purchases_state');
     //   return dd($query->get());
        return view('adverts', ['adverts' => $query->get()]);
    }

    public function delete(Request $request)
    {
        $selectedItems = $request->input('check', []);
        $advertsInPurchase = Purchase::whereIn('advert_id', $selectedItems)->pluck('advert_id');
        if ($advertsInPurchase->isNotEmpty()) {
            $advertsTitle = Advert::whereIn('id',$advertsInPurchase)->pluck('title');
            return redirect()->back()->with([
                'not_deleted_adverts' => $advertsTitle,
            ]);
        }

        return dd('ok');
        $purchasesForDelete = Purchase::whereIn('advert_id', $selectedItems)->get();

        foreach ($selectedItems as $itemId) {
            Advert::find($itemId)->delete();
        }
        return redirect()->back()->with('success', 'Selected items deleted successfully.');
    }

    public function showEditForm(Request $request)
    {
        $id = $request['id'];
        return view(
            'advert_edit',
            [
                'advert' => Advert::find($id),
                'categories' => Category::where('parent_id', '!=', null)->get(),
            ]);
    }

    public function change(Request $request)
    {
        $isImageChanged = isset($request['image']);

        if (!$isImageChanged) {
            unset($this->fieldsForValidate['image']);
        }

        $validatedData = $request->validate($this->fieldsForValidate);

        $advert = Advert::find($request['id']);
        $advert->title = $validatedData['title'];
        $advert->price = $request['price'];
        $advert->category_id = $request['category'];
        $advert->description = $request['description'];

        if ($isImageChanged) {
            $imagePath = $request->file('image')->store('', 'public');
            $advert->image = $imagePath;
        }

        $advert->save();

        Pref::updateOrCreate(
            ['key' => Constants::advert_last_update]
        );

        return $this->show();
    }
}
