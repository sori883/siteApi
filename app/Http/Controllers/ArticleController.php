<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Http\Requests\Article\ArticleStoreRequest;
use App\Http\Requests\Article\ArticleUpdateRequest;
use App\UseCase\Article\FetchAllArticleAction;
use App\UseCase\Article\FetchIndexArticleAction;
use App\UseCase\Article\FetchCategoryArticleAction;
use App\UseCase\Article\StoreAction;
use App\UseCase\Article\UpdateAction;
use App\UseCase\Article\DeleteAction;
use App\UseCase\Article\VisibleAction;
use App\Http\Resources\Article\ArticleCollection;
use App\Http\Resources\Article\ArticleViewResource;
use App\Http\Resources\Article\ArticleIndexCollection;
use App\Http\Resources\Article\ArticleCategoryList;

class ArticleController extends Controller
{
    /**
     * 全ての記事を取得する
     *
     * @param FetchAllArticleAction $action
     * @return ArticleCollection
     */
    public function fetchAllArticles(FetchAllArticleAction $action): ArticleCollection
    {
        $user = auth()->user();
        $currentPage = request()->get('page', 1);
        return new ArticleCollection($action($user, $currentPage));
    }

    /**
    * TOPに表示する記事一覧
    *
    * @param FetchAllArticleAction $action
    * @return ArticleCollection
    */
    public function fetchIndexArticles(FetchIndexArticleAction $action): ArticleIndexCollection
    {
        return new ArticleIndexCollection($action());
    }

    /**
    *  カテゴリーに紐づく記事を取得する
    *
    * @param FetchAllArticleAction $action
    * @return ArticleCollection
    */
    public function fetchCategoryArticles(FetchCategoryArticleAction $action, string $slug): ArticleCategoryList
    {
        $requestCategory = Category::where('slug', $slug)->first();
        return new ArticleCategoryList($action($requestCategory));
    }

    /**
     * 特定の記事を取得する
     *
     * @param Article $article
     * @return ArticleViewResource
     */
    public function fetchArticles(Article $article): ArticleViewResource
    {
        return new ArticleViewResource(Article::find($article->id));
    }

    /**
     * 特定の記事を取得する
     *
     * @param Article $article
     * @return ArticleViewResource
     */
    public function fetchArticlesFromPermalink(string $permalink): ArticleViewResource
    {
        return new ArticleViewResource(Article::where('permalink', $permalink)->first());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleStoreRequest $request, StoreAction $action): ArticleViewResource
    {
        $user = $request->user();
        $article = $request->makeArticle();
        $tags = $request->makeTags();
        $category = $request->makeCategory();
        $image = $request->makeImage();

        return new ArticleViewResource($action($article, $user, $tags, $category, $image));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Article $article, ArticleUpdateRequest $request, UpdateAction $action): ArticleViewResource
    {
        $this->authorize('update', $article);
        $articleRequest = $request->makeArticle();
        $tags = $request->makeTags();
        $category = $request->makeCategory();
        $image = $request->makeImage();

        return new ArticleViewResource($action($article, $articleRequest, $tags, $category, $image));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article, DeleteAction $action)
    {
        $this->authorize('delete', $article);
        $action($article);
        return response(200);
    }

    /**
     * 記事の公開、非公開を切り替える
     *
     * @param Article $article
     * @return void
     */
    public function visible(Article $article, VisibleAction $action)
    {
        $this->authorize('visible', $article);
        return new ArticleViewResource($action($article));
    }
}
