<div>
    @error('items')
        <span class="text-red-600">{{ $message }}</span>
    @enderror

    <form wire:click.prevent="submit" method="POST" class="mt-4">
        @csrf
        <table class="min-w-full divide-y divide-gray-200 border mb-4"
            x-data="{
                products: @js($products),
                items: {},
                totalPrice: 0,
                updateTotal: function(productId, quantity) {
                    this.items[productId] = this.products.find(p => p.id === productId).price * quantity;
                    this.totalPrice = Object.values(this.items).reduce((a, b) => a + b, 0);
                  }
            }"
        >
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Product</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Price</span>
                    </th>
                    <th class="px-6 py-3 bg-gray-50 text-left">
                        <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Quantity</span>
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
                            ${{ number_format($product->price, 2) }}
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            <input wire:model="items.{{ $product->id }}" @click="updateTotal({{ $product->id }}, $event.target.value)" type="number" min="0" />
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
