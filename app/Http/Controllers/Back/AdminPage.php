<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Prophecy\Doubler\Generator\Node\ArgumentNode;

class AdminPage extends Controller
{
    public function index()
    {
        $pages=Page::all();
        return view('back.pages.index',compact('pages'));
    }

    public function switch(Request $request)
    {
        $page = Page::findOrFail($request->id);
        $page->status = $request->statu == 'true' ? 1 : 0;
        $page->save();
    }

    public function create()
    {
        return view('back.pages.create');
    }

    public function post(Request $request)
    {
        $request->validate(
            [
                'title' => 'min:3',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

        $last=Page::orderBy('order','DESC')->first();

        $page = new Page();
        $page->title = $request->title;
        $page->content = $request->icerikContent;
        $page->order=$last->order+1;
        $page->slug = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);
            $page->image = 'uploads/' . $imageName;
        }
        $page->save();
        toastr()->success('Sayfa başarıyla oluşturuldu...', 'Başarılı');
        return redirect()->route('admin.page.index');
    }

    public function update($id)
    {
        $page=Page::findOrFail($id);
        return view('back.pages.edit',compact('page'));
    }

    public function updatePost(Request $request,$id)
    {
        $request->validate(
            [
                'title' => 'min:3',
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

        $page = Page::findOrFail($id);
        $page->title = $request->title;
        $page->content = $request->icerikContent;
        $page->slug = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);
            $page->image = 'uploads/' . $imageName;
        }
        $page->save();
        toastr()->success('Başarılı', 'Sayfa başarıyla güncellendi...');
        return redirect()->route('admin.page.index');
    }

    public function delete(Request $request)
    {
        $delete = Page::findOrFail($request->id);
        $delete->delete();
        toastr()->error('Sayfa Kalıcı Olarak Silindi', 'Silindi');
        return redirect()->route('admin.page.index');
    }

    public function orders(Request $request)
    {
        foreach ($request->get('page') as $key=> $order)
        {
            Page::where('id',$order)->update(['order'=>$key]);
        }
    }
}
