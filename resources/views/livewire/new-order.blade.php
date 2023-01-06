<form action="{{ route('orders.store') }}" method="POST">
    @csrf
    <x-validation-errors class="mb-4" :errors="$errors" />

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
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                    {{ $product->name }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                    ${{ number_format($product->price, 2) }}
                </td>
                <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                    <input wire:model="quantities.{{ $product->id }}"
                           type="number"
                           name="quantities[{{ $product->id }}]" />
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th colspan="2"></th>
            <th class="px-6 py-4 text-left font-semibold">
                Total price: ${{ number_format($totalPrice, 2) }}
            </th>
        </tr>
        </tfoot>
    </table>
    <x-button>Place Order</x-button>
</form>
