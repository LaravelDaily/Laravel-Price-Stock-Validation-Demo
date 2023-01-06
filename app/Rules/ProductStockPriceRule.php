<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\InvokableRule;

class ProductStockPriceRule implements InvokableRule
{
    /**
     * All of the data under validation.
     *
     * @var array
     */
    protected array $data = [];

    public function __construct(array $prices = [])
    {
        $this->data['prices'] = $prices;
    }

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
            if ($DBProducts[$productID]->price != $this->data['prices'][$productID]) {
                $errorText .= 'Sorry, the price of ' . $DBProducts[$productID]->name . ' has changed. 
                    Old price: $' . number_format($this->data['prices'][$productID], 2) . ', 
                    new price: $' . number_format($DBProducts[$productID]->price, 2) . '. ';
            }
        }

        if ($errorText != '') {
            $fail($errorText);
        }
    }
}
