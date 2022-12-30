<div>
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <table class="min-w-full divide-y divide-gray-200 border mb-4">
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
                    <input type="hidden" name="prices[{{ $product->id }}]" value="{{ $product->price }}" />
                    <tr class="bg-white">
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            {{ $product->name }}
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            ${{ number_format($product->price, 2) }}
                        </td>
                        <td class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                            <input wire:change="updateTotalPrice($event.target.value, {{ $product->id }})" wire:key="product.{{ $product->id }}" type="number" name="products[{{ $product->id }}]" value="{{ old('products.' . $product->id, 0) }}" min="0" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th class="px-6 py-4" colspan="3">
                        <span class="font-semibold">Total price: {{ $totalPrice }}</span>
                    </th>
                </tr>
            </tfoot>
        </table>
        <x-button>Place Order</x-button>
    </form>
</div>
