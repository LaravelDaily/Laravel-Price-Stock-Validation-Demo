<div>
    @error('items')
        <span class="text-red-600">{{ $message }}</span>
    @enderror

    <form wire:click.prevent="submit" method="POST" class="mt-4">
        <table class="mb-4 min-w-full border divide-y divide-gray-200"
               wire:poll.10s="checkStock"
               x-data="{
                   products: @js($products),
                   items: {},
                   totalPrice: @entangle('totalPrice'),
                   updateTotal: function(productId, quantity) {
                       this.items[productId] = this.products.find(p => p.id === productId).price * quantity;
                       this.totalPrice = Object.values(this.items).reduce((a, b) => a + b, 0);
                   }
               }"
            >
            <thead>
                <tr>
                    <th class="bg-gray-50 px-6 py-3 text-left">
                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Product</span>
                    </th>
                    <th class="bg-gray-50 px-6 py-3 text-left">
                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Price</span>
                    </th>
                    <th class="bg-gray-50 px-6 py-3 text-left">
                        <span class="text-xs font-medium uppercase leading-4 tracking-wider text-gray-500">Quantity</span>
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                @foreach($products as $product)
                    <input wire:model="prices.{{ $product->id }}" type="hidden" />
                    <tr class="bg-white">
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            {{ $product->name }}
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            @if (!empty($updatedPrices) && array_key_exists($product->id, $updatedPrices))
                                <span class="text-xs">(${{ number_format($oldPrices[$product->id], 2) }})</span> ${{ number_format($updatedPrices[$product->id], 2) }}
                            @else
                                ${{ number_format($product->price, 2) }}
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            <div class="flex flex-col">
                                <input wire:model="items.{{ $product->id }}" @click="updateTotal({{ $product->id }}, $event.target.value)" type="number" min="0" />
                                @error("quantity.{$product->id}")
                                    <span class="mt-2 text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="px-6 py-4" colspan="3">
                        <span class="font-semibold">Total price: <span x-text="'$' + totalPrice.toFixed(2)"></span></span>
                    </th>
                </tr>
            </tfoot>
        </table>
        <x-button>Place Order</x-button>
    </form>
</div>

@push('scripts')
    <script>
        /*window.addEventListener('DOMContentLoaded', () => {
            window.Livewire.on('updateTotalPrice', value => {
                this.totalPrice = value;
            })
        })*/
    </script>
@endpush