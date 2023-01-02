<?php

namespace App\Http\Requests;

use App\Rules\ProductStockPriceRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'items' => new ProductStockPriceRule(),
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}