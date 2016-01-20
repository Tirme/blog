<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Field;
use RepositoryFactory;

class ArticleController extends Controller
{
    public function listPage()
    {
        return view('blog.article_list');
    }
}
