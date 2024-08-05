<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class News extends Model
{
    public $timestamps = false;

    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'create_time',
        'title',
        'preview',
        'content',
        'preview_img',
        'content_img',
        'author',
        'recommend_list',
    ];
}
