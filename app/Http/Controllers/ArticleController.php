<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Requests\Article\ArticlePostRequest;
use App\UseCase\Article\FetchAllArticleAction;
use App\UseCase\Article\StoreAction;
use App\Http\Resources\Article\ArticleCollection;
use App\Http\Resources\Article\ArticleResource;

class ArticleController extends Controller
{

    /**
     * Policyのため
     */
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticlePostRequest $request, StoreAction $action)
    {
        $article = $request->makeArticle();
        $tags = $request->makeTags();
        $category = $request->makeCategory();
        $user = $request->user();
        return new ArticleResource($action($article, $user, $tags, $category));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return response(200);
    }
}
