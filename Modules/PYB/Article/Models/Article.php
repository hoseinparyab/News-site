<?php

namespace PYB\Article\Models;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;
use PYB\Article\Enums\TypeTextArticleEnum;
use PYB\Category\Models\Category;
use PYB\Comment\Trait\HaveComments;
use PYB\User\Models\User;

class Article extends Model implements Viewable
{
    use HasFactory, InteractsWithViews, Likeable, HaveComments;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'time_to_read',
        'imageName',
        'imagePath',
        'score',
        'status',
        'type',
        'body',
        'keywords',
        'description',
        'type_text',
        'videoName',
        'videoPath',
    ];

    public const STATUS_ACTIVE = 'active';
    public const STATUS_PENDING = 'pending';
    public const STATUS_INACTIVE = 'inactive';

    public static array $statuses = [self::STATUS_ACTIVE, self::STATUS_PENDING, self::STATUS_INACTIVE];

    public const TYPE_VIP = 'vip';
    public const TYPE_NORMAL = 'normal';

    public static array $types = [self::TYPE_VIP, self::TYPE_NORMAL];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    // Methods
    public function cssStatus()
    {
        if ($this->status === self::STATUS_ACTIVE) return 'success';
        else if ($this->status === self::STATUS_INACTIVE) return 'danger';
        else return 'warning';
    }

    public function path()
    {
        return route('articles.details', $this->slug);
    }

    public function isVideoArticle(): bool
    {
        return $this->type_text === TypeTextArticleEnum::TYPE_TEXT_VIDEO->value && ! is_null($this->videoName);
    }
    //  public function getCommentCount()  //FIXED: 1- change the method name to getCommentsCount
    // {
    //    if(is_null($this->comments)) return 0;
    //      return $this->comments->count();

    // }
}
