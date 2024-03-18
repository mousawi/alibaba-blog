<?php

namespace App\Filament\Resources;

use App\Enums\ArticleStatus;
use App\Filament\Resources\ArticleResource\Pages;
use App\Filament\Resources\ArticleResource\RelationManagers;
use App\Models\Article;
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

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('Author')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->hidden(fn (): bool => ! auth()->user()->is_admin),


                Forms\Components\TextInput::make('title')
                    ->required()
                    ->string()
                    ->maxLength(255)
                    ->live()
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->required(),

                Forms\Components\RichEditor::make('content')
                    ->required(),

                Forms\Components\DateTimePicker::make('publication_date')
                    ->required()
                    ->seconds(false)
                    ->native(false)
                    ->beforeOrEqual('now')
                    ->dehydrateStateUsing(fn (string $state): string => Carbon::parse($state))
                    ->dehydrated(fn ($state) => filled($state)),

                Forms\Components\Select::make('publication_status')
                    ->options([
                        '0' => 'Draft',
                        '1' => 'Published',
                    ])
                    ->required()
                    ->enum(ArticleStatus::class)
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author.name')->label('Author')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('publication_date')
                    ->formatStateUsing(
                        fn (Carbon $state): string =>
                        $state->toFormattedDateString() . ' (' . $state->diffForHumans() . ')'
                    ),
                Tables\Columns\TextColumn::make('publication_status')
                    ->badge()
                    ->formatStateUsing(fn (ArticleStatus $state): string => $state->string())
                    ->color(
                        fn (ArticleStatus $state): string =>
                        $state->color()
                    )
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
