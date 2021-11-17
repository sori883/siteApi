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
        return $this->belongsTo('App\Models\User');
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo('App\Models\Image');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Tag')->withTimestamps();
    }

    public function comments(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Comment')->withTimestamps();
    }
}
