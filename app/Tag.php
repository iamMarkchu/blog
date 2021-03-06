<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    const STATUS_NORMAL = 1;
    const STATUS_DELETED = 2;

    protected $fillable = [
        'url_name', 'name', 'display_order', 'status', 'user_id'
    ];
    public function user()
    {
        return $this->belongsTo("App\User", "user_id");
    }

    public function articles()
    {
        return $this->belongsToMany("App\Article");
    }
}
