<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Article;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleDeleteModalTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @test */
    function can_delete_articles()
    {
        Storage::fake();

        $imagePath = UploadedFile::fake()
            ->image('image.png')
            ->store('/', 'public');

        $article = Article::factory()->create([
            'image' => $imagePath
        ]);

        $user = User::factory()->create();

        Livewire::actingAs($user)->test('article-delete-modal', ['article' => $article])
            ->call('delete')
            ->assertSessionHas('status')
            ->assertRedirect(route('articles.index'));

        Storage::disk('public')->assertMissing($imagePath);

        $this->assertDatabaseCount('articles', 0);
    }
}
