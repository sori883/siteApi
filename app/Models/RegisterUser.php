<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterUser extends Model
{
    use HasFactory;

    protected $primaryKey = 'email';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'email',
        'name',
    ];

    // create_atだけを使用したいので、デフォルトタイムスタンプを無効
    // かつcreate_atを自前で用意
    public $timestamps = false;
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }
}
