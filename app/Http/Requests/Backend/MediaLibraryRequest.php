<?php

namespace App\Http\Requests\BackEnd;

use Illuminate\Foundation\Http\FormRequest;

class MediaLibraryRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $currentURL = \URL::current();

        if (strpos($currentURL, 'storeCkEditor') > 0) {
            return [
                'upload' => 'required',
            ];
        }

        return [
            'files' => 'required',
        ];
    }
}
