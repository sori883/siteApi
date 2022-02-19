<?php

namespace App\Http\Requests\Tag;

use App\Http\Requests\ApiRequest;

class TagUpdateRequest extends ApiRequest
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
            'text' => 'required|string|max:20'
        ];
    }

    public function makeTag(): array
    {
        return [
            'text' => $this->validated()['text'],
        ];
    }
}
