<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Collection;

class ArticleStoreRequest extends FormRequest
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
            'title' => 'required|string|max:100',
            'entry' => 'required|string|max:30000',
            'permalink' => 'required|string|max:20',
            'publish_at' => 'required|boolean',
            'image_id' => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'tags' => 'nullable|json|regex:/^(?!.*\s).+$/u|regex:/^(?!.*\/).*$/u'
        ];
    }

    public function makeArticle(): Article
    {
        return new Article($this->validated());
    }

    public function makeCategory(): Category
    {
        return Category::where('id', $this->validated()['category_id'])->first();
    }

    public function makeTags(): Collection
    {
        return collect(json_decode($this->validated()['tags']))
            ->slice(0, 5) // タグは5個までにするため
            ->map(function ($requestTag) {
                return $requestTag->text;
            });
    }
}
