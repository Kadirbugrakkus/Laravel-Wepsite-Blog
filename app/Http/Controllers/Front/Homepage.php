<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

//Models
use App\Models\Content;
use App\Models\Category;
use App\Models\Page;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;


class Homepage extends Controller
{
    public function __construct()
    {
        if (Config::find(1)->active==0)
        {
            return abort(403, 'Sayfa Erişime Kapalıdır!');
        }
        view()->share('pages', Page::where('status',1)->orderBy('order', 'ASC')->get());
    }

    public function index()
    {
        /* where içine bir koşul alır */
        /*$data = Category::where('slug','=','eglence')->get();*/

        $contents = Content::with('getCategory')->where('status',1)->orderBy('created_at', 'DESC')->paginate(10);
        $contents->withpath(url('sayfa'));
        $data = Category::select('categories.*', DB::raw('count(contents.category_id) as total'))
            ->leftJoin('contents', function ($join) {
                $join->on('categories.id', '=', 'contents.category_id');
            })
            ->where('categories.status',1)
            ->groupBy('categories.id')
            ->get();
        return view('front.homepage',
            [
                'data' => $data,
                'contents' => $contents,
            ]);
    }

    public function single($category, $slug)
    {
        $category = Category::whereSlug($category)->first() ?? abort(403, 'Böyle Bir Kategori Bulunamadı');
        $content = Content::whereSlug($slug)->whereCategoryId($category->id)->first() ?? abort(403, 'Böyle Bir Sayfa Bulunamadı');
        $content->increment('hit');
        $data = Category::select('categories.*', DB::raw('count(contents.category_id) as total'))
            ->leftJoin('contents', function ($join) {
                $join->on('categories.id', '=', 'contents.category_id');
            })
            ->groupBy('categories.id')
            ->get();
        return view('front.single',
            [
                'data' => $data,
                'contents' => $content
            ]);
    }

    public function category($slug)
    {

        $category = Category::whereSlug($slug)->first() ?? abort(403, 'Böyle Bir Kategori Bulunamadı');
        $data['category'] = $category;
        $data['contents'] = Content::where('category_id', $category->id)->orderby('created_at', 'DESC')->paginate(3);

        $leftCategories = Category::where('name','Genel')
            ->select('categories.*', DB::raw('count(contents.category_id) as total'))
            ->leftJoin('contents', function ($join) {
                $join->on('categories.id', '=', 'contents.category_id');
            })
            ->groupBy('categories.id')
            ->get();
        return view('front.category', [
            'category' => $data['category'],
            'contents' => $data['contents'],
            'data' => $leftCategories
        ]);
    }

    public function page($slug)
    {

        $page = Page::where('status',1)->whereSlug($slug)->first() ?? abort(404);
        $data = $page;

        return view('front.page',
            [
                'page' => $data,

            ]);
    }

    public function contact()
    {
        return view('front.contact',
            [

            ]);
    }

    public function contactpost(Request $request)
    {
        $rules =
            [
                'name' => 'required|min:5',
                'email' => 'required|email',
                'topic' => 'required',
                'message' => 'required|min:10',
            ];
        $validator = Validator::make($request->post(), $rules);

        if ($validator->fails())
        {

            return redirect()->route('contact')->withErrors($validator)->withInput();
        }

        Mail::send([],[],function ($message) use ($request) {
            $message->from('iletisim@denemesitesi.com','Deneme Sitesi');
            $message->to('60kadirfb@gmail.com');
            $message->setBody(' Mesajı Gönderen : '.$request->name.'<br>
                    Mesajı Gönderen Mail : '.$request->email.'<br>
                    Mesaj Konusu : '.$request->topic.'<br>
                    Mesaj : '.$request->message.'<br><br>
                    Mesaj Gönderim Tarihi :'.now().'','text/html');
            $message->subject($request->name.' iletişimden mesaj gönderdi');
        });

        //$contact = new  contact;
        //$contact->name = $request->name;
        //$contact->email = $request->email;
        //$contact->topic = $request->topic;
        //$contact->message = $request->message;
        //$contact->save();


        return redirect()->route('contact')->with('success', 'Mesajınız İletildi..');
    }
}
