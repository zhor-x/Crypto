<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsCollection extends ResourceCollection
{
     /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return \Illuminate\Support\Collection
     */
    public function toArray($request)
    {
        return $this->collection;
    }

}
