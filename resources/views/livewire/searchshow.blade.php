<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component
{
    #[Validate('array', 'min:1', 'max:3')]
    public array $shows = [];

    public function submit(): void
    {
        $shows = array_filter($this->shows);

        if (empty($shows)) {
            $this->addError('shows', 'Please enter at least one show.');

            return;
        }

        if (count($shows) > 3) {
            $this->addError('shows', 'Please enter a maximum of three shows.');

            return;
        }

        // encrypt the shows and redirect to the recommendation page
        $encryptedShows = encrypt(implode('+', $shows));

        $this->redirect(route('recommendations', ['shows' => $encryptedShows]));
    }
}; ?>

<div>
    <x-input-error :messages="$errors->get('shows')" class="mb-5 text-lg" />

    <form class="space-y-6" wire:submit.prevent="submit">
        <div class="relative">
            <x-text-input type="text" placeholder="Enter Show 1" required wire:model="shows.0" class="w-full p-4" />
            <span class="absolute right-4 top-3 text-orange-600">🎬</span>
        </div>
        <div class="relative">
            <x-text-input type="text" placeholder="Enter Show 2 (optional)" wire:model="shows.1" class="w-full p-4" />
            <span class="absolute right-4 top-3 text-orange-600">📺</span>
        </div>
        <div class="relative">
            <x-text-input type="text" placeholder="Enter Show 3 (optional)" wire:model="shows.2" class="w-full p-4" />
            <span class="absolute right-4 top-3 text-orange-600">🎥</span>
        </div>

        <button
            type="submit"
            class="w-full rounded-lg bg-orange-600 py-4 text-lg font-semibold text-white shadow-lg transition hover:bg-orange-700"
        >
            Get Recommendations
        </button>
    </form>
</div>
