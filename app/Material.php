<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    const TYPE_IMAGE = 1; // 图片类型

    const STATUS_NORMAL = 1;
    const STATUS_DELETED = 2;
}
