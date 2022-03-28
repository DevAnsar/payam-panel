<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PackageCollection extends ResourceCollection
{
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
                'icon'=>asset('storage/'.$pack->icon)
            ];
        });
    }
}
