<?php

namespace Tests\Feature\Livewire;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ArticleFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function article_form_renders_properly()
    {
        $this->get(route('articles.create'))
            ->assertSeeLivewire('article-form');

        $article = Article::factory()->create();

        $this->get(route('articles.edit', $article))
            ->assertSeeLivewire('article-form');
    }

    /** @test */
    function blade_template_is_wired_properly()
    {
        Livewire::test('article-form')
            ->assertSeeHtml('wire:submit.prevent="save"')
            ->assertPropertyWired('article.title')
            ->assertPropertyWired('article.content');
    }

    /** @test */
    function can_create_new_articles()
    {
        Livewire::test('article-form')
            ->set('article.title', 'New article')
            ->set('article.content', 'Article content')
            ->call('save')
            ->assertSessionHas('status')
            ->assertRedirect(route('articles.index'))
        ;

        $this->assertDatabaseHas('articles', [
            'title' => 'New article',
            'content' => 'Article content'
        ]);
    }

    /** @test */
    function can_update_articles()
    {
        $article = Article::factory()->create();

        Livewire::test('article-form', ['article' => $article])
            ->assertSet('article.title', $article->title)
            ->assertSet('article.content', $article->content)
            ->set('article.title', 'Updated title')
            ->call('save')
            ->assertSessionHas('status')
            ->assertRedirect(route('articles.index'))
        ;

        $this->assertDatabaseCount('articles', 1);

        $this->assertDatabaseHas('articles', [
            'title' => 'Updated title',
        ]);
    }

    /** @test */
    function title_is_required()
    {
        Livewire::test('article-form')
            ->set('article.content', 'Article content')
            ->call('save')
            ->assertHasErrors(['article.title' => 'required'])
            ->assertSeeHtml(__('validation.required', ['attribute' => __('validation.attributes.title')]))
        ;
    }

    /** @test */
    function title_must_be_4_characters_min()
    {
        Livewire::test('article-form')
            ->set('article.title', 'Art')
            ->set('article.content', 'Article content')
            ->call('save')
            ->assertHasErrors(['article.title' => 'min'])
            ->assertSeeHtml(__('validation.min.string', [
                'attribute' => __('validation.attributes.title'),
                'min' => 4
            ]))
        ;
    }

    /** @test */
    function content_is_required()
    {
        Livewire::test('article-form')
            ->set('article.title', 'Article title')
            ->call('save')
            ->assertHasErrors(['article.content' => 'required'])
            ->assertSeeHtml(__('validation.required', ['attribute' => __('validation.attributes.content')]))
        ;
    }

    /** @test */
    function real_time_validation_works_for_title()
    {
        Livewire::test('article-form')
            ->set('article.title', '')
            ->assertHasErrors(['article.title' => 'required'])
            ->set('article.title', 'New')
            ->assertHasErrors(['article.title' => 'min'])
            ->set('article.title', 'New Article')
            ->assertHasNoErrors('article.title')
        ;
    }

    /** @test */
    function real_time_validation_works_for_content()
    {
        Livewire::test('article-form')
            ->set('article.content', '')
            ->assertHasErrors(['article.content' => 'required'])
            ->set('article.content', 'Article content')
            ->assertHasNoErrors('article.content')
        ;
    }
}
