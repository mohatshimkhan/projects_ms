<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;

class HomeController extends Controller
{
    /**
     * Show the application Home Page.
     */
    public function index(){
        //return view('frontend.home');
        return view('home');
    }


}