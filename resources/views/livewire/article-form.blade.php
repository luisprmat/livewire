<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New article') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <x-form-section submit="save">
                <x-slot name="title">
                    {{ __('New article') }}
                </x-slot>
                <x-slot name="description">
                    {{ __('Create a new article') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6 sm:col-span-4">
                        <x-select-image wire:model="image" :image="$image" :existing="$article->image"/>
                        <x-input-error for="image" class="mt-2"/>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="title" :value="__('Title')"/>
                        <x-input wire:model="article.title" id="title" class="mt-1 w-full" type="text"/>
                        <x-input-error for="article.title" class="mt-2"/>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="slug" :value="__('Slug')"/>
                        <x-input wire:model="article.slug" id="slug" class="mt-1 w-full" type="text"/>
                        <x-input-error for="article.slug" class="mt-2"/>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="category_id" :value="__('Category')"/>
                        <div class="flex space-x-2 mt-1">
                            <x-select wire:model="article.category_id" :options="$categories" id="category_id" :placeholder="__('Select category')" class="w-full"/>
                            <x-secondary-button wire:click="openCategoryForm" class="!p-2.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </x-secondary-button>
                        </div>
                        <x-input-error for="article.category_id" class="mt-2"/>
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="content" :value="__('Content')"/>
                        <x-html-editor wire:model="article.content" id="content" class="mt-1 w-full"></x-html-editor>
                        <x-input-error for="article.content" class="mt-2"/>
                    </div>
                </x-slot>

                <x-slot name="actions">
                    @if ($this->article->exists)
                        <livewire:article-delete-modal :article="$article">
                            <x-danger-button wire:click="$emit('confirmArticleDeletion', {{ $article }})" class="mr-auto">
                                {{ __('Delete') }}
                            </x-danger-button>
                        </livewire:article-delete-modal>
                    @endif

                    <x-button>
                        {{ __('Save') }}
                    </x-button>
                </x-slot>

            </x-form-section>
        </div>
    </div>

    <x-modal wire:model="showCategoryModal">
        <form wire:submit.prevent="saveNewCategory">
            <div class="px-6 py-4">
                <div class="text-lg">
                    {{ __('New Category') }}
                </div>

                <div class="mt-4 space-y-2">
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="new-category-name" :value="__('Name')"/>
                        <x-input wire:model="newCategory.name" id="new-category-name" class="mt-1 w-full" type="text"/>
                        <x-input-error for="newCategory.name" class="mt-2"/>
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="new-category-slug" :value="__('Slug')"/>
                        <x-input wire:model="newCategory.slug" id="new-category-slug" class="mt-1 w-full" type="text"/>
                        <x-input-error for="newCategory.slug" class="mt-2"/>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-100 text-right space-x-2">
                <x-secondary-button wire:click="closeCategoryForm">{{ __('Cancel') }}</x-secondary-button>
                <x-button>{{ __('Submit') }}</x-button>
            </div>
        </form>
    </x-dialog-modal>
</div>
