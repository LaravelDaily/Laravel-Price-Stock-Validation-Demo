<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\InvokableRule;

class ProductStockPriceRule implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $products = array_filter($value);
        if (count($products) == 0) {
            $fail('Please select at least one product');
        }

        $DBProducts = Product::find(array_keys($products))->keyBy('id');

        $errorText = '';
        foreach ($products as $productID => $quantity) {
            // Check stock
            if ($DBProducts[$productID]->stock_left < $quantity) {
                $errorText .= 'Sorry, we have only ' . $DBProducts[$productID]->stock_left . ' of ' . $DBProducts[$productID]->name . ' left in stock. ';
            }

            // Check price
        }

        if ($errorText != '') {
            $fail($errorText);
        }
    }
}
