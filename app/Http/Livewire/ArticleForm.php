<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ArticleForm extends Component
{
    public Article $article;

    protected function rules()
    {
        return [
            'article.title' => ['required', 'min:4'],
            'article.slug' => [
                'required',
                Rule::unique('articles', 'slug')->ignore($this->article)
            ],
            'article.content' => ['required']
        ];
    }

    /** Need for creating articles */
    public function mount(Article $article)
    {
        $this->article = $article;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        $this->article->save();

        session()->flash('status', __('Article saved.'));

        $this->redirectRoute('articles.index');
    }

    public function render()
    {
        return view('livewire.article-form');
    }
}
