<?php

namespace App\Enums;

enum ArticleStatus: int
{
    case DRAFT = 0;
    case PUBLISHED = 1;

    public function string(): string
    {
        return match ($this) {
            ArticleStatus::DRAFT => 'Draft',
            ArticleStatus::PUBLISHED => 'Published',
        };
    }

    public function color(): string
    {
        return match ($this) {
            ArticleStatus::DRAFT => 'warning',
            ArticleStatus::PUBLISHED => 'success',
        };
    }
}
