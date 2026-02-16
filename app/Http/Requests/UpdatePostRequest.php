<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title_pt' => 'required|string|max:255',
            'body_pt' => 'required|string',

            'title_en' => 'nullable|string|max:255',
            'body_en' => 'nullable|string',

            'category' => 'required',
            'is_highlighted' => 'boolean',
            'tags*'        => 'required',
        ];
    }
}
