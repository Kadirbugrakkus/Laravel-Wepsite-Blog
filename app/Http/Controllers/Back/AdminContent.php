<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Content;
use App\Models\Category;
use phpDocumentor\Reflection\Types\Context;
use Illuminate\Support\Str;

class AdminContent extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $content = Content::orderBy('created_at', 'ASC')->get();
        return view('Back.Content.index', compact('content'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('Back.Content.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'title' => 'min:3',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

        $content = new Content;
        $content->title = $request->title;
        $content->category_id = $request->category;
        $content->content = $request->icerikContent;
        $content->slug = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);
            $content->image = 'uploads/' . $imageName;
        }
        $content->save();
        toastr()->success('İçerik başarıyla oluşturuldu...', 'Başarılı');
        return redirect()->route('admin.icerikler.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $icerik = Content::findOrFail($id);
        if ($icerik)
            $categories = Category::all();
        return view('Back.Content.edit', compact('categories', 'icerik'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'title' => 'min:3',
                'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

        $content = Content::findOrFail($id);
        $content->title = $request->title;
        $content->category_id = $request->category;
        $content->content = $request->icerikContent;
        $content->slug = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $imageName = Str::slug($request->title) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('uploads'), $imageName);
            $content->image = 'uploads/' . $imageName;
        }
        $content->save();
        toastr()->success('Başarılı', 'İçerik başarıyla güncellendi...');
        return redirect()->route('admin.icerikler.index');
    }

    public function switch(Request $request)
    {
        $content = Content::findOrFail($request->id);
        $content->status = $request->statu == 'true' ? 1 : 0;
        $content->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function delete($id)
    {
        Content::find($id)->delete();
        toastr()->warning('İçerik Silinenlere Taşındı', 'Taşındı');
        return redirect()->route('admin.icerikler.index');
    }

    public function trashed()
    {
        $content = Content::onlyTrashed()->orderBy('deleted_at', 'DESC')->get();
        return view('back.content.trashed', compact('content'));
    }

    public function recover($id)
    {
        Content::onlyTrashed()->find($id)->restore();
        toastr()->success('İçerik Başarıyla Kurtarıldı', 'Başarılı');
        return redirect()->route('admin.trashed.content');
    }

    public function hardDelete($id)
    {
        $hardDelete = Content::onlyTrashed()->find($id);
        if (File::exists($hardDelete->image))
        {
            File::delete(public_path($hardDelete->image));
        }
        $hardDelete->forceDelete();
        toastr()->error('İçerik Kalıcı Olarak Silindi', 'Silindi');
        return redirect()->route('admin.trashed.content');
    }
}
