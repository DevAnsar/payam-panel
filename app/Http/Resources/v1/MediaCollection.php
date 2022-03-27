<?php

namespace App\Http\Resources\v1;

use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MediaCollection extends ResourceCollection
{

    private $user;
    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource,User $user = null)
    {
        parent::__construct($resource);

        $this->resource = $this->collectResource($resource);
        $this->user=$user;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($media){
            $data = [
                'id'=>$media->id,
                'title'=>$media->title,
                'icon'=>asset("storage/".$media->icon),
                'base_url'=>$media->base_url
            ];
            if ($this->user){
                $data = array_merge($data,[
                    'user_value'=> new LinkResource($this->user->links()->where('media_id',$media->id)->first())
                ]);
            }

            return $data;
        });
    }
}
