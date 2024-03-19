<?php

namespace App\Models;

use App\Enums\ArticleStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'publication_date',
        'publication_status'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'publication_date' => 'datetime',
            'publication_status' => ArticleStatus::class,
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id', 'id')->withTrashed();
    }

    public function isDraft(): bool
    {
        return $this->publication_status === ArticleStatus::Draft;
    }

    public function isPublished(): bool
    {
        return $this->publication_status === ArticleStatus::Published;
    }
}
