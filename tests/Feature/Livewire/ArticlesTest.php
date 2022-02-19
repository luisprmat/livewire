<?php

namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticlesTest extends TestCase
{
    /** @test */
    function articles_component_renders_properly()
    {
        $this->markTestSkipped();
        // $this->get('dashboard/blog')->assertSeeLivewire('articles-table');
    }
}
