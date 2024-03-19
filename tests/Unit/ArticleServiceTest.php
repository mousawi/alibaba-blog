<?php

namespace Tests\Unit;

use App\Enums\ArticleStatus;
use App\Models\Article;
use App\Models\User;
use App\Services\ArticleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class ArticleServiceTest extends TestCase
{
    use RefreshDatabase;

    private ArticleService $articleService;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->articleService = new ArticleService();
    }

    private function create_user()
    {
        return User::create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_admin' => false
        ]);
    }

    /**
     * A basic unit test example.
     */
    public function test_create_article(): void
    {
        $user = $this->create_user();

        $article = $this->articleService->store([
            'user_id' => $user->id,
            'title' => fake()->title(),
            'slug' => fake()->slug(),
            'content' => fake()->randomHtml(2, 3),
            'publication_date' => fake()->dateTime(),
            'publication_status' => fake()->randomElement(ArticleStatus::cases())->value
        ]);

        $this->assertDatabaseHas('articles', [
            'title' => $article->title
        ]);
    }

    public function test_update_article(): void
    {
        $user = $this->create_user();

        $article = $this->articleService->store([
            'user_id' => $user->id,
            'title' => fake()->title(),
            'slug' => fake()->slug(),
            'content' => fake()->randomHtml(2, 3),
            'publication_date' => fake()->dateTime(),
            'publication_status' => fake()->randomElement(ArticleStatus::cases())->value
        ]);

        $this->assertDatabaseHas('articles', [
            'title' => $article->title
        ]);

        $newTitle = fake()->title();

        $this->articleService->update($article, [
            'title' => $newTitle,
        ]);

        $this->assertDatabaseHas('articles', [
            'title' => $article->title
        ]);
    }

    public function test_publish_article(): void
    {
        $user = $this->create_user();

        $article = $this->articleService->store([
            'user_id' => $user->id,
            'title' => fake()->title(),
            'slug' => fake()->slug(),
            'content' => fake()->randomHtml(2, 3),
            'publication_date' => fake()->dateTime(),
            'publication_status' => ArticleStatus::Draft
        ]);

        $this->assertDatabaseHas('articles', [
            'publication_status' => ArticleStatus::Draft->value
        ]);

        $this->articleService->publishArticle($article);

        $this->assertDatabaseHas('articles', [
            'publication_status' => ArticleStatus::Published->value
        ]);
    }

    public function test_draft_article(): void
    {
        $user = $this->create_user();

        $article = $this->articleService->store([
            'user_id' => $user->id,
            'title' => fake()->title(),
            'slug' => fake()->slug(),
            'content' => fake()->randomHtml(2, 3),
            'publication_date' => fake()->dateTime(),
            'publication_status' => ArticleStatus::Published
        ]);

        $this->assertDatabaseHas('articles', [
            'publication_status' => ArticleStatus::Published->value
        ]);

        $this->articleService->draftArticle($article);

        $this->assertDatabaseHas('articles', [
            'publication_status' => ArticleStatus::Draft->value
        ]);
    }


    public function test_bulk_publish_article(): void
    {
        $user = $this->create_user();

        $articles = new Collection();

        foreach (range(0,4) as $i) {
            $articles->add($this->articleService->store([
                'user_id' => $user->id,
                'title' => fake()->title(),
                'slug' => fake()->slug(),
                'content' => fake()->randomHtml(2, 3),
                'publication_date' => fake()->dateTime(),
                'publication_status' => ArticleStatus::Draft
            ]));
        }

        $this->assertDatabaseCount('articles', 5);

        $this->assertDatabaseHas('articles', [
            'publication_status' => ArticleStatus::Draft->value
        ]);

        $this->articleService->bulkPublishArticles($articles);

        $this->assertDatabaseHas('articles', [
            'publication_status' => ArticleStatus::Published->value
        ]);
    }

    public function test_bulk_draft_article(): void
    {
        $user = $this->create_user();

        $articles = new Collection();

        foreach (range(0,4) as $i) {
            $articles->add($this->articleService->store([
                'user_id' => $user->id,
                'title' => fake()->title(),
                'slug' => fake()->slug(),
                'content' => fake()->randomHtml(2, 3),
                'publication_date' => fake()->dateTime(),
                'publication_status' => ArticleStatus::Published
            ]));
        }

        $this->assertDatabaseCount('articles', 5);

        $this->assertDatabaseHas('articles', [
            'publication_status' => ArticleStatus::Published->value
        ]);

        $this->articleService->bulkDraftArticles($articles);

        $this->assertDatabaseHas('articles', [
            'publication_status' => ArticleStatus::Draft->value
        ]);
    }

}
