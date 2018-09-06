<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    const STATUS_NORMAL = 1;
    const STATUS_DELETED = 2;
    const STATUS_PENDING = 3;
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
