<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewItem extends FormRequest
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
    public function rules()
    {
        return [
            // 'description' => 'required',
            'quantity' => 'required|integer|min:0',
            'category' => 'required',
            'image' => 'image',
            'dayPrice' => 'required|numeric|between:0,999.99',
            'weekPrice' => 'required|numeric|between:0,999.99',
            'order' => 'nullable|integer',
            'files.*' => 'file',
            'fileNames.*' => 'nullable|string',
            //
        ];
    }

}
