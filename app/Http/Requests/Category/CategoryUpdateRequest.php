<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\ApiRequest;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends ApiRequest
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
            'name' => ['required', 'string', 'max:20',],
            'slug' => ['required', 'regex:/^[0-9a-zA-Z_-]+$/', 'string', 'max:20',
                        Rule::unique('categories')->ignore($this->slug, 'slug')],
        ];
    }

    public function makeCategory(): array
    {
        return [
            'name' => $this->validated()['name'],
            'slug' => $this->validated()['slug'],
        ];
    }
}
