<?php

namespace Modules\SysAdmin\resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
