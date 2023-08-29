<div>
    <x-confirmation-modal wire:model="showDeleteModal">
        <x-slot name="title">{{ __('Are you sure?') }}</x-slot>
        <x-slot name="content">
            {{ __('Do you want to delete the article: :article?', ['article' => $article->title]) }}
        </x-slot>
        <x-slot name="footer">
            <x-button wire:click.prevent="$set('showDeleteModal', false)" class="mr-auto">{{ __('Cancel') }}</x-button>
            <x-danger-button wire:click.prevent="delete">{{ __('Confirm') }}</x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
