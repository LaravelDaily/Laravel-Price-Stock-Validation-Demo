<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use App\Http\Requests\OrderStoreRequest;
use Illuminate\Database\Eloquent\Collection;

class NewOrder extends Component
{
    public Collection $products;
    public array $items = [];
    public array $prices = [];
    public array $updatedPrices = [];
    public array $oldPrices = [];
    public int $totalPrice = 0;

    public function mount(): void
    {
        $this->products = Product::all();

        foreach ($this->products as $product) {
            $this->prices[$product->id] = $product->price;
            $this->items[$product->id] = 0;
        }
    }

    public function submit()
    {
        $this->validate();

        // save to DB...
    }

    public function checkStock(): void
    {
        $this->products = Product::all();

        foreach ($this->products as $product) {
            if ($product->price != $this->prices[$product->id]) {
                $this->oldPrices[$product->id] = $this->prices[$product->id];
                $this->updatedPrices[$product->id] = $this->prices[$product->id] = $product->price;
            }

            if ($product->stock_left < $this->items[$product->id]) {
                $this->items[$product->id] = $product->stock_left;
                $this->addError('quantity.' . $product->id, "Only {$product->stock_left} left in stock");
            }
        }

        foreach ($this->items as $id => $quantity) {
            $this->reset('totalPrice');
            $this->totalPrice += $this->products->find($id)->price * $quantity;
        }

//        $this->emit('updateTotalPrice', $this->totalPrice);

//        $this->reset('totalPrice');
    }

    public function render(): View
    {
        return view('livewire.new-order');
    }

    protected function rules(): array
    {
        return (new OrderStoreRequest())->rules();
    }
}
