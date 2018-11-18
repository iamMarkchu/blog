<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Filterable;

    protected $fillable  = ['url_name', 'title', 'content', 'cover', 'display_order', 'status', 'source', 'user_id'];
    const STATUS_NORMAL = 1;
    const STATUS_DELETED = 2;
    const STATUS_PENDING = 0;
    const STATUS_ALL = -1;

    public function user()
    {
        return $this->belongsTo("App\User", "user_id");
    }

    public function categories()
    {
        return $this->belongsToMany("App\Category");
    }

    public function tags()
    {
        return $this->belongsToMany("App\Tag");
    }
}
