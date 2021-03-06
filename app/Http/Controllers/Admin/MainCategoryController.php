<?php
namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use DB;
use Illuminate\Support\Str;
class MainCategoryController extends Controller
{
    public function index(){
         $default_lang=get_default_language();
        $categories=MainCategory::where('translation_lang',$default_lang)->selection()->get();
        return view('admin.mainCategory.index',compact('categories'));
    }

public function create(){
    return view("admin.mainCategory.create");
}


public function store(MainCategoryRequest $request)
{

    try {
        //return $request;

        $main_categories = collect($request->category);

        $filter = $main_categories->filter(function ($value, $key) {
            return $value['abbr'] == get_default_language();
        });

        $default_category = array_values($filter->all()) [0];


        $filePath = "";
        if ($request->has('photo')) {

            $filePath = uploadImage($request->photo,'maincategory');
        }

        DB::beginTransaction();

        $default_category_id = MainCategory::insertGetId([
            'translation_lang' => $default_category['abbr'],
            'translation_of' => 0,
            'name' => $default_category['name'],
            'slug' => $default_category['name'],
            'photo' => $filePath
        ]);

        $categories = $main_categories->filter(function ($value, $key) {
            return $value['abbr'] != get_default_language();
        });


        if (isset($categories) && $categories->count()) {

            $categories_arr = [];
            foreach ($categories as $category) {
                $categories_arr[] = [
                    'translation_lang' => $category['abbr'],
                    'translation_of' => $default_category_id,
                    'name' => $category['name'],
                    'slug' => $category['name'],
                    'photo' => $filePath
                ];
            }

            MainCategory::insert($categories_arr);
        }

        DB::commit();

        return redirect()->route('admin.MainCategory')->with(['success' => '???? ?????????? ??????????']);

    } catch (\Exception $ex) {
        DB::rollback();


        return redirect()->route('admin.MainCategory')->with(['error' => '?????? ?????? ???? ?????????? ???????????????? ??????????']);
    }

}






public function edit($mainCat_id)
{
    //get specific categories and its translations
    $mainCategory = MainCategory::with('categories')
        ->selection()
        ->find($mainCat_id);

    if (!$mainCategory)
        return redirect()->route('admin.MainCategory')->with(['error' => '?????? ?????????? ?????? ?????????? ']);

    return view('admin.mainCategory.edit', compact('mainCategory'));
}


public function update($mainCat_id, MainCategoryRequest $request)
{


    try {
        $main_category = MainCategory::find($mainCat_id);

        if (!$main_category)
            return redirect()->route('admin.MainCategory')->with(['error' => '?????? ?????????? ?????? ?????????? ']);

        // update date

        $category = array_values($request->category) [0];

        if (!$request->has('category.0.active'))
            $request->request->add(['active' => 0]);
        else
            $request->request->add(['active' => 1]);


        MainCategory::where('id', $mainCat_id)
            ->update([
                'name' => $category['name'],
                'active' => $request->active,
            ]);

        // save image

        if ($request->has('photo')) {
            $filePath = uploadImage($request->photo,'maincategories');
            MainCategory::where('id', $mainCat_id)
                ->update([
                    'photo' => $filePath,
                ]);
        }


        return redirect()->route('admin.MainCategory')->with(['success' => '???? ?????????????? ??????????']);
    } catch (\Exception $ex) {

        return redirect()->route('admin.MainCategory')->with(['error' => '?????? ?????? ???? ?????????? ???????????????? ??????????']);
    }

}


public function destroy($id)
{

    try {
        $maincategory = MainCategory::find($id);
        if (!$maincategory)
            return redirect()->route('admin.MainCategory')->with(['error' => '?????? ?????????? ?????? ?????????? ']);

        $vendors = $maincategory->vendors();
        if (isset($vendors) && $vendors->count() > 0) {
            return redirect()->route('admin.MainCategory')->with(['error' => '???? ???????? ?????? ?????? ??????????  ']);
        }

        $image = Str::after($maincategory->photo, 'assets/');
        $image = base_path('assets/' . $image);
        unlink($image); //delete from folder

        $maincategory->delete();
        return redirect()->route('admin.MainCategory')->with(['success' => '???? ?????? ?????????? ??????????']);

    } catch (\Exception $ex) {
        return redirect()->route('admin.MainCategory')->with(['error' => '?????? ?????? ???? ?????????? ???????????????? ??????????']);
    }
}

public function changeStatus($id)
{
    try {
        $maincategory = MainCategory::find($id);
        if (!$maincategory)
            return redirect()->route('admin.MainCategory')->with(['error' => '?????? ?????????? ?????? ?????????? ']);

       $status =  $maincategory -> active  == 0 ? 1 : 0;

       $maincategory -> update(['active' =>$status ]);

        return redirect()->route('admin.MainCategory')->with(['success' => ' ???? ?????????? ???????????? ?????????? ']);

    } catch (\Exception $ex) {
        return redirect()->route('admin.MainCategory')->with(['error' => '?????? ?????? ???? ?????????? ???????????????? ??????????']);
    }
}


}
?>
