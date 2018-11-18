<?php namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class ArticleFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function status($status)
    {
        if ($status !== '')
            return $this->where('status', $status);
    }

    public function title($title)
    {
        return $this->where('title', 'like', "%$title%");
    }

    public function source($source)
    {
        if ($source)
            return $this->where('source', $source);
    }
}
