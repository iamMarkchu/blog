<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    const STATUS_NORMAL = 1;
    const STATUS_DELETED = 2;
}
