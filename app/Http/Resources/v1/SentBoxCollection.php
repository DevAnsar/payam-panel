<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SentBoxCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item){
            return[
                'id'=>$item->id,
                'mobile'=>$item->mobile,
                'date'=>Verta($item->created_at)->format('Y/n/j'),
                'time'=>Verta($item->created_at)->format('H:i'),
                'text'=>$item->text,
            ];
        });
    }
}
