<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static paginate(int $cntItemsPerPage)
 * @method static truncate()
 */
class News extends Model
{
    public $timestamps = false;

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'create_time',
        'preview',
        'content',
        'preview_img',
        'content_img',
        'author',
        'recommend_list',
    ];
}
