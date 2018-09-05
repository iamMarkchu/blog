<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const STATUS_NORMAL = 1;
    const STATUS_DELETED = 2;

    public function parentCategory()
    {
        return $this->belongsTo("App\Category", "parent_id");
    }
}
