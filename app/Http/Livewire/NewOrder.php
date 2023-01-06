<?php

namespace App\Http\Livewire;

use App\Rules\ProductStockPriceRule;
use Illuminate\Support\Collection;
use Livewire\Component;

class NewOrder extends Component
{
    public Collection $products;
    public array $quantities = [];
    public array $prices = [];
    public int $totalPrice = 0;

    public function mount()
    {
        foreach ($this->products as $product) {
            $this->quantities[$product->id] = 0;
        }

        $this->prices = $this->products->pluck('price', 'id')->toArray();
    }

    public function updatedQuantities()
    {
        $this->validate([
            'quantities' => new ProductStockPriceRule($this->prices),
        ]);

        $this->totalPrice = 0;
        foreach ($this->quantities as $productId => $quantity) {
            $product = $this->products->find($productId);
            if ($product) {
                $this->totalPrice += $product->price * $quantity;
            }
        }
    }

    public function render()
    {
        return view('livewire.new-order');
    }
}
