<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PackageCollection extends ResourceCollection
{

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->resource = $this->collectResource($resource);
    }


    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($pack){
            return[
                'id'=>$pack->id,
                'title'=>$pack->title,
                'price'=>$pack->price,
                'count'=>$pack->count,
                'days'=>$pack->days,
                'icon'=>asset('storage/'.$pack->icon)
            ];
        });
    }
}
