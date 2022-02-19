<?php

namespace App\Http\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticlesTable extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.articles-table', [
            'articles' => Article::where(
                'title', 'LIKE', "%{$this->search}%"
            )->latest()->get()
        ]);
    }
}