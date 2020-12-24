<?php

namespace App\Http\Controllers\web;

use App\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Term;

class PagesController extends Controller
{
    public function about_us()
    {
        $about = About::first()->body;
        return view('web.pages.about',compact('about'));
    }
    public function terms()
    {
        $terms = Term::first()->body;
        return view('web.pages.terms',compact('terms'));

    }
}
