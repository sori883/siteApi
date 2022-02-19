<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\ApiRequest;
use App\Models\Category;

class CategoryStoreRequest extends ApiRequest
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
            'name' => 'required|string|max:20',
            'slug' => 'required|string|max:20',
        ];
    }

    public function makeCategory(): Category
    {
        return new Category($this->validated());
    }
}
