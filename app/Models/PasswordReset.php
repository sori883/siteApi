<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

       protected $primaryKey = 'email';
       protected $keyType = 'string';
       public $incrementing = false;

       protected $fillable = [
           'email',
           'token',
       ];

       public $timestamps = false;
       public static function boot()
       {
           parent::boot();
           static::creating(function ($model) {
               $model->created_at = $model->freshTimestamp();
           });
       }
}
