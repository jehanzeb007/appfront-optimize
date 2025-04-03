<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'description' => 'nullable|string',
            'image' => 'nullable|file',
            'price' => 'nullable|numeric',
        ];
    }
}
