<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\UseCase\Category\StoreAction;
use App\UseCase\Category\UpdateAction;
use App\UseCase\Category\FetchAllCategoryAction;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryListResource;

class CategoryController extends Controller
{
    /**
     * 全てのカテゴリーを取得する
     *
     * @param FetchAllCategoryAction $action
     * @return CategoryCollection
     */
    public function fetchAllCategories(FetchAllCategoryAction $action): CategoryCollection
    {
        return new CategoryCollection($action());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request, StoreAction $action)
    {
        $user = $request->user();
        $category = $request->makeCategory();

        return new CategoryListResource($action($category, $user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, Category $category, UpdateAction $action)
    {
        $this->authorize('update', $category);
        $categoryRequest = $request->makeCategory();
        return new CategoryListResource($action($category, $categoryRequest));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        $category->delete();
        return response(200);
    }
}
