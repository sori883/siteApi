<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = [
        'deleted_at',
        'publish_at',
    ];

    protected $fillable = [
        'title',
        'entry',
        'permalink',
        'publish_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function comments(): hasMany
    {
        return $this->hasMany(Comment::class)->withTimestamps();
    }

    /**
     * 公開日時を設定
     *
     * @param  boolean  $bool
     * @return void
     */
    public function setPublishAtAttribute($bool)
    {
        $this->attributes['publish_at'] = $bool ? Carbon::now() : null;
    }

    /**
     * 公開日時を取得
     *
     * @param  datatime  $value
     * @return Carbon
     */
    public function getPublishAtAttribute($value)
    {
        // limit_atをyyyy/mm/dd形式で取得する
        return $value ? Carbon::parse($value)->format('Y/m/d') : null;
    }
}
