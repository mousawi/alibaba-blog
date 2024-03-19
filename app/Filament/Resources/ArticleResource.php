<?php

namespace App\Filament\Resources;

use App\Enums\ArticleStatus;
use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use App\Services\ArticleService;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->hidden(fn (): bool => !auth()->user()->is_admin)
                    ->label('Author')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),


                Forms\Components\TextInput::make('title')
                    ->required()
                    ->string()
                    ->maxLength(255)
                    ->live()
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->string()
                    ->maxLength(255)
                    ->required(),

                Forms\Components\RichEditor::make('content')
                    ->string()
                    ->maxLength(255)
                    ->required(),

                Forms\Components\DateTimePicker::make('publication_date')
                    ->required()
                    ->seconds(false)
                    ->native(false)
                    ->beforeOrEqual('now')
                    ->dehydrateStateUsing(fn (string $state): string => Carbon::parse($state))
                    ->dehydrated(fn ($state) => filled($state)),

                Forms\Components\Select::make('publication_status')
                    ->options(ArticleStatus::class)
                    ->required()
                    ->enum(ArticleStatus::class)
                    ->hidden(fn (): bool => !auth()->user()->is_admin),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('author.name')
                    ->label('Author')
                    ->searchable(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug'),

                Tables\Columns\TextColumn::make('publication_date')
                    ->formatStateUsing(fn (Carbon $state): string => $state->toFormattedDateString() . ' (' . $state->diffForHumans() . ')'),

                Tables\Columns\TextColumn::make('publication_status')
                    ->badge()
                    ->formatStateUsing(fn (ArticleStatus $state): string => $state->string())
                    ->color(fn (ArticleStatus $state): string => $state->color())
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('Publish Article')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-rocket-launch')
                    ->color('success')
                    ->visible(fn (Article $article) => ($article->isDraft() && auth()->user()->is_admin))
                    ->action(fn (Article $article, ArticleService $articleService) => $articleService->publishArticle($article)),

                Tables\Actions\Action::make('Draft Article')
                    ->requiresConfirmation()
                    ->icon('heroicon-o-rocket-launch')
                    ->color('warning')
                    ->visible(fn (Article $article) => ($article->isPublished() && auth()->user()->is_admin))
                    ->action(fn (Article $article, ArticleService $articleService) => $articleService->draftArticle($article)),

                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),

                    Tables\Actions\BulkAction::make('Publish Articles')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn (Collection $articles, ArticleService $articleService) => $articleService->bulkPublishArticles($articles))
                        ->visible(auth()->user()->is_admin)
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('Draft Articles')
                        ->icon('heroicon-o-check-badge')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(fn (Collection $articles, ArticleService $articleService) => $articleService->bulkDraftArticles($articles))
                        ->visible(auth()->user()->is_admin)
                        ->deselectRecordsAfterCompletion()
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
