<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function homePage()
    {
        return view('blog');
    }
}
