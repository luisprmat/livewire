<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class ArticleForm extends Component
{
    use WithFileUploads;

    public Article $article;

    public $image;

    protected function rules()
    {
        return [
            'image' => ['image', 'max:512'],
            'article.title' => ['required', 'min:4'],
            'article.slug' => [
                'required',
                'alpha_dash',
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

    public function updatedArticleTitle($title)
    {
        $this->article->slug = Str::slug($title);
    }

    public function save()
    {
        $this->validate();

        $this->article->image = $this->image->store('/', 'public');

        Auth::user()->articles()->save($this->article);

        session()->flash('status', __('Article saved.'));

        $this->redirectRoute('articles.index');
    }

    public function render()
    {
        return view('livewire.article-form');
    }
}
