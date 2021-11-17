<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = [
        'deleted_at',
        'publish_at',
    ];

    protected $fillable = [
        'name',
        'comment_entry',
        'publish_at',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo('App\Models\Article');
    }
}
