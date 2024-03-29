<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CategoryRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        if($request->has('category_id'))
        {
        return [
            'name' => 'required',
            'slug' => 'required',
            'status' => 'required',
        ];
    }
    else{
        return [
            'name' => 'required',
            'slug' => 'required|unique:categories',
            'status' => 'required',
        ];
    }
    }
    public function messages()
    {
        return [
            'name' => 'name must be required',
            'slug' => 'Slug must be required.',
            'status' => 'status must be required.',
            'image' => 'image must be required'
        ];
    }
}
