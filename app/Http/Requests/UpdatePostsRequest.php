<?php

namespace App\Http\Requests;

class UpdatePostsRequest extends ApiRequest
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
        //
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => "Поле 'title' обязательное!",
            'content.required' => "Поле 'content' обязательное!",
        ];
    }
}
