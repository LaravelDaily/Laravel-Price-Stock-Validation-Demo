<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use App\Http\Requests\OrderStoreRequest;
use Illuminate\Database\Eloquent\Collection;

class NewOrder extends Component
{
    public Collection $products;
    public array $items = [];
    public array $prices = [];
    public int $totalPrice = 0;

    public function mount(): void
    {
        foreach ($this->products as $product) {
            $this->prices[$product->id] = $product->price;
        }
    }

    public function updateTotalPrice(int $quantity, int $productId): void
    {
        $this->items[$productId] = $this->products->find($productId)->price * $quantity;

        $this->totalPrice = array_sum($this->items);
    }

    public function submit(OrderStoreRequest $request)
    {
        $this->validate();

        // save to DB...
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
