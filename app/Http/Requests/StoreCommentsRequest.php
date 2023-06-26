<?php

namespace App\Http\Requests;

class StoreCommentsRequest extends ApiRequest
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
            'text' => 'required',
            'posts_id' => 'required'
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'text.required' => "Поле 'text' обязательное!",
            'posts_id.required' => "Поле 'posts_id' обязательное!",
        ];
    }
}
