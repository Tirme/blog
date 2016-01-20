<?php

namespace App\Http\Controllers;

use RepositoryFactory;

class IndexController extends Controller
{
    public function homePage()
    {
        $albums = with(RepositoryFactory::create('Gallery\Album'))
            ->getRows(10);
        return view('home', [
            'albums' => $albums
        ]);
    }
}
