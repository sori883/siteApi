<?php

namespace App\Http\Requests\Article;

use App\Http\Requests\ApiRequest;
use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class ArticleUpdateRequest extends ApiRequest
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
     * バリデーション前の処理
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'tags' => json_encode($this->tags),
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'entry' => ['required', 'string', 'max:30000'],
            'permalink' => ['required', 'regex:/^[0-9a-zA-Z_-]+$/', 'string', 'max:20',
                                    Rule::unique('articles')->ignore($this->permalink, 'permalink')],
            'publish_at' => ['required', 'boolean'],
            'image_id' => ['nullable', 'integer'],
            'category_id' => ['nullable', 'integer'],
            'tags' => ['nullable', 'json', 'regex:/^(?!.*\s).+$/u', 'regex:/^(?!.*\/).*$/u']
        ];
    }

    public function makeArticle(): array
    {
        return [
            'title' => $this->validated()['title'],
            'entry' => $this->validated()['entry'],
            'permalink' => $this->validated()['permalink'],
            'publish_at' => $this->validated()['publish_at'],
            'image_id' => $this->validated()['image_id'],
        ];
    }

    public function makeCategory()
    {
        return $this->validated()['category_id'] ?
        Category::where('id', $this->validated()['category_id'])->first()
        :
        null;
    }

    public function makeImage()
    {
        return $this->validated()['image_id'] ?
        Image::where('id', $this->validated()['image_id'])->first()
        :
        null;
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
