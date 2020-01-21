<?php

namespace App\Http\Requests\BackEnd\PostBlog;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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

        if ($this->method() == "GET") {
            return [];
        }
        return [
            'title' => 'required',
            'the_excerpt' => 'required'
        ];
    }

    public function messages()
    {
        return [
            // 'name.required' => 'A title is required',
            // 'name.max' => 'A title is max 255',
            // 'name.unique' => 'A title is max 255',
        ];
    }
}
