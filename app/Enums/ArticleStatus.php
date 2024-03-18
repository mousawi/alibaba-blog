<?php

namespace App\Enums;

enum ArticleStatus: int
{
    case Draft = 0;
    case Published = 1;

    public function string(): string
    {
        return match ($this) {
            ArticleStatus::Draft => 'Draft',
            ArticleStatus::Published => 'Published',
        };
    }

    public function color(): string
    {
        return match ($this) {
            ArticleStatus::Draft => 'warning',
            ArticleStatus::Published => 'success',
        };
    }
}
