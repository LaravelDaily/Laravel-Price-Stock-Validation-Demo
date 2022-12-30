<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class NewOrder extends Component
{
    public Collection $products;
    public array $items = [];
    public int $totalPrice = 0;

    public function updateTotalPrice(int $quantity, int $productId): void
    {
        $this->items[$productId] = $this->products->find($productId)->price * $quantity;

        $this->totalPrice = array_sum($this->items);
    }

    public function render(): View
    {
        return view('livewire.new-order');
    }
}
