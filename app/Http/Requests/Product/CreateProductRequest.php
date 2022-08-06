<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required|integer|unique:products,product_id',
            'product_name' => 'required|string',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'category_id' => 'required|integer'
        ];
    }
}
