<?php

use Livewire\Component;

new class extends Component
{
    public int $count = 0;
    public int $amount = 1;
    public string $error = '';

    public function increment()
    {
        $this->error = '';
        $this->count += $this->amount;
    }

    public function decrement()
    {
        if($this->count > 0 && $this->count >= $this->amount) {
            $this->error = '';
            $this->count -= $this->amount;
        } else {
            $this->error = "Ne možete smanjiti ispod nule!";
        }
    }

    public function validateAmount()
    {
        $this->error = $this->amount < 1 ? "Amount ne može biti manji od 1" : '';
    }
};
?>

<div>
    <p class="text-red-500">{{ $error }}</p>
    <p class="text-white">Clicked times: <span class="{{ $count < 3000 ? 'text-white' : 'text-red-600' }}">{{ $count }}</span></p>
    <button wire:click="increment" class="bg-indigo-600 text-white p-3">
        Povećaj
    </button>
    <button class="bg-indigo-600 text-white p-3" wire:click="decrement">
        Smanji
    </button>

    <input type="number" min="1" wire:blur="validateAmount" wire:model.live="amount"
        class="border border-white text-white p-3"
    >
    <p class="text-white">Amount is: {{ $amount }}</p>
</div>