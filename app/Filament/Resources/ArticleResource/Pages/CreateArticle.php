<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (!auth()->user()->is_admin) {
            unset($data['user_id']);
            unset($data['publication_status']);
        }

        return $data;
    }
}
