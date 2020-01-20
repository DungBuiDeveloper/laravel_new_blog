<?php

namespace App\Http\Requests\BackEnd\PostBlog;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
            'tag_name' => 'required|max:255',
            'slug' => 'unique',
        ];
    }

    public function messages()
    {
        return [
            'tag_name.required' => 'A title is required',
            'name.max' => 'A title is max 255',
            'name.unique' => 'A title is max 255',
        ];
    }
}
