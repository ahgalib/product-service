<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:products,slug,' . $this->route('id'),
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'brand_id'       => 'sometimes|exists:brands,id',
            'category_id'    => 'sometimes|exists:categories,id',
            'subcategory_id' => 'sometimes|exists:subcategories,id',
            'status' => 'in:active,inactive',
        ];
    }
}
