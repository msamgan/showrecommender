<?php

use Livewire\Attributes\Url;
use Livewire\Volt\Component;

new class extends Component
{
    #[Url]
    public string $shows = '';

    public array $decryptedShows = [];

    public function mount(): void
    {
        $this->decryptedShows = explode('+', decrypt($this->shows));
    }
}; ?>

<div>//</div>
