<?php

namespace App\Services;

use App\Enums\ArticleStatus;
use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

class ArticleService
{
    public function store(array $data): Article
    {
        if (auth()->user()->cannot('create', Article::class)) {
            abort(403);
        }

        return Article::create($data);
    }

    public function update(Article $article, array $data): bool
    {
        if (auth()->user()->cannot('update', $article)) {
            abort(403);
        }

        return $article->update($data);
    }

    public function publishArticle(Article $article): bool
    {
        if (auth()->user()->cannot('update', $article)) {
            abort(403);
        }

        return $article->update(['publication_status' => ArticleStatus::Published]);
    }

    public function bulkPublishArticles(Collection $articles): bool
    {
        if (auth()->user()->cannot('updateAny', Article::class)) {
            abort(403);
        }

        return Article::whereIn('id', $articles->pluck('id'))->update(['publication_status' => ArticleStatus::Published]);
    }

    public function draftArticle(Article $article): bool
    {
        if (auth()->user()->cannot('update', $article)) {
            abort(403);
        }

        return $article->update(['publication_status' => ArticleStatus::Draft]);
    }

    public function bulkDraftArticles(Collection $articles): bool
    {
        if (auth()->user()->cannot('updateAny', Article::class)) {
            abort(403);
        }

        return Article::whereIn('id', $articles->pluck('id'))->update(['publication_status' => ArticleStatus::Draft]);
    }
}
