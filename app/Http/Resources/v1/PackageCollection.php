<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PackageCollection extends ResourceCollection
{

    /**
     * The resource that this resource collects.
     *
     * @var
     */
    private $smsTariff;

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @param $smsTariff
     */
    public function __construct($resource,$smsTariff)
    {
        parent::__construct($resource);

        $this->smsTariff = $smsTariff;
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
                'tariff'=>(int)$pack->price/(int)$pack->count,
                'icon'=>asset('storage/'.$pack->icon)
            ];
        });
    }
}
