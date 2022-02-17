<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Requests\Article\ArticleStoreRequest;
use App\Http\Requests\Article\ArticleUpdateRequest;
use App\UseCase\Article\FetchAllArticleAction;
use App\UseCase\Article\StoreAction;
use App\UseCase\Article\UpdateAction;
use App\Http\Resources\Article\ArticleCollection;
use App\Http\Resources\Article\ArticleViewResource;

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
        return new ArticleCollection($action($user));
    }

    /**
     * 特定の記事を取得する
     *
     * @param Article $article
     * @return ArticleViewResource
     */
    public function fetchArticles(Article $article): ArticleViewResource
    {
        return new ArticleViewResource($article);
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

        return new ArticleViewResource($action($article, $user, $tags, $category));
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

        return new ArticleViewResource($action($article, $articleRequest, $tags, $category));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        $article->tags()->detach();
        $article->delete();
        return response(200);
    }

    /**
     * 記事の公開、非公開を切り替える
     *
     * @param Article $article
     * @return void
     */
    public function visible(Article $article)
    {
        $this->authorize('visible', $article);
        $article->publish_at = !$article->publish_at ? true : false;
        $article->save();
        return response(200);
    }
}
