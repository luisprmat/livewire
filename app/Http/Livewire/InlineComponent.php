<?php

namespace App\Http\Livewire;

use Livewire\Component;

class InlineComponent extends Component
{
    public function render()
    {
        return <<<'blade'
            <div>
                Inline Component
            </div>
        blade;
    }
}
