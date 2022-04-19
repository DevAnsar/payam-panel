<?php

namespace App\Http\Resources\v1;

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserPackageCollection extends ResourceCollection
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
                'description'=>$item->description,
                'price'=>$item->price,
                'count'=>$item->count,
                'inventory'=>$item->inventory,
                'tariff'=>$item->tariff,
                'expired_at'=>Verta($item->expired_at)->format('%d %B %Y'),
                'expired_diff'=>Verta($item->expired_at)->formatDifference(Verta(Carbon::now())),
            ];
        });
    }
}
