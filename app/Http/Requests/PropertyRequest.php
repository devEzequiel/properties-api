<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'rental_price' => 'required',
            'sale_price' => 'required '
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'título obrigatório',
            'description.required' => 'descrição obrigatória',
            'rental_price.required' => 'preço do aluguel é obrigatório',
            'sale_price.required' => 'preço de venda é obrigatório'
        ];
    }
}
