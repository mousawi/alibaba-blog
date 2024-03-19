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
        $articles = Article::with('author')->published()->paginate(6);

        return view('articles.index', ['articles' => $articles]);
    }

    public function show($slug): View
    {
        $article = Article::whereSlug($slug)->first();

        abort_if(is_null($article), 404);

        return view('articles.show', ['article' => $article]);
    }

}
