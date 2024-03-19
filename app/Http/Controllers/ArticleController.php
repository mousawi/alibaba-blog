<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use \Illuminate\Contracts\View\View;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author')->paginate(6);

        return view('articles.index', ['articles' => $articles]);
    }

    public function show(Article $article): View
    {
        return view('articles.show', ['article' => $article]);
    }

}
