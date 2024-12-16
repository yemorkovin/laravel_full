<?php

namespace App\Http\Controllers;
use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    public function index()
    {
        
        $data = json_decode(file_get_contents('main.json'), true);
        $news = json_decode(file_get_contents('articles.json'), true);
       

        return view('pages.home',compact('news','data'));
    }
    public function galery($id)
    {

        $news = json_decode(file_get_contents('articles.json'), true);
        $full_image = $news[$id-1]['full_image'];
       
        return view('pages.galery',compact('full_image'));
    }

    
 
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {

        $data = [
            'title' => 'Контакты',
            'text' => 'Свяжитесь с нами'
        ];
        return view('pages.contact', compact('data'));
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:500',
        ]);

        $data = $request->only(['name', 'email', 'message']);
        $filePath = storage_path('app/contacts.json');

        $contacts = file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];
        $contacts[] = $data;

        file_put_contents($filePath, json_encode($contacts));

        return back()->with('success', 'Ваше сообщение успешно отправлено!');
    }
}
