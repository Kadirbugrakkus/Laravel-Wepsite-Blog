<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class AdminCategory extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('back.categories.index', compact('categories'));
    }

    public function switch(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->status = $request->statu == 'true' ? 1 : 0;
        $category->save();

        $contents = Content::where('category_id',$request->id)->get();
        foreach($contents as $content){
            $content->status = $request->statu == 'true' ? 1 : 0;
            $content->save();
        }
    }

    public function create(Request $request)
    {
        $isExist = Category::whereSlug(Str::slug($request->categroy))->first();
        if ($isExist) {
            toastr()->error($request->category . ' Adında Kategori Zaten Mevcut..', 'Hata');
            return redirect()->route('admin.category.index');
        }
        $category = new Category();
        $category->name = $request->category;
        $category->slug = Str::slug($request->title);
        $category->save();
        toastr()->success('Kategori Başarıyla Oluşturuldu..', 'Başarılı');
        return redirect()->route('admin.category.index');
    }

    public function getData(Request $request)
    {
        $category = Category::findOrFail($request->id);
        return response()->json($category);
    }

    public function update(Request $request)
    {
        $isSlug = Category::whereSlug(Str::slug($request->slug))->whereNotIn('id', [$request->id])->first();
        $isName = Category::whereName(($request->category))->whereNotIn('id', [$request->id])->first();
        if ($isSlug or $isName) {
            toastr()->error($request->category . ' Adında Kategori Zaten Mevcut..', 'Hata');
            return redirect()->route('admin.category.index');
        }
        $category = Category::find($request->id);
        $category->name = $request->category;
        $category->slug = Str::slug($request->slug);
        $category->save();
        toastr()->success('Kategori Başarıyla Güncellendi..', 'Başarılı');
        return redirect()->route('admin.category.index');
    }

    public function delete(Request $request)
    {
        $category = Category::findOrFail($request->id);
        if ($category->id == 1) {
            toastError('Bu Kategori Silinemez !');
            return redirect()->route('admin.category.index');
        }
        $message =' ';
        $count = count($category->categoryCount);
        if ($count > 0) {
            Content::where('category_id', $category->id)->update(['category_id' => 1]);
            $defaultCategory = Category::find(1);
            $message = 'Bu kategoriye ait ' . $count . ' içerik ' . $defaultCategory->name . ' kategorisine taşındı.';
        }
        $category->delete();
        toastError($message,'Bu Kategori Başariyla Silindi !');
        return redirect()->route('admin.category.index');
    }
}

//href="{{route('admin.icerikler.edit',$category->id)}}"
//href="{{route('admin.delete.content',$category->id)}}"
