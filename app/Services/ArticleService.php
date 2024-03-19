<?php

namespace App\Services;

use App\Enums\ArticleStatus;
use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

class ArticleService
{
    public function store(array $data): Article
    {
        return Article::create($data);
    }

    public function update(Article $article, array $data): bool
    {
        return $article->update($data);
    }

    public function publishArticle(Article $article): bool
    {
        return $article->update(['publication_status' => ArticleStatus::Published]);
    }

    public function bulkPublishArticles(Collection $articles): bool
    {
        return Article::whereIn('id', $articles->pluck('id'))->update(['publication_status' => ArticleStatus::Published]);
    }

    public function draftArticle(Article $article): bool
    {
        return $article->update(['publication_status' => ArticleStatus::Draft]);
    }

    public function bulkDraftArticles(Collection $articles): bool
    {
        return Article::whereIn('id', $articles->pluck('id'))->update(['publication_status' => ArticleStatus::Draft]);
    }
}
