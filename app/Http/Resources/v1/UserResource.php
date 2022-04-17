<?php

namespace App\Http\Resources\v1;


use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    /**
     * The resource instance.
     *
     * @var integer
     */
    private int $smsTariff;

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @param $smsTariff
     */
    public function __construct($resource,$smsTariff)
    {
        $this->smsTariff = $smsTariff;
        $this->resource = $resource;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name' => $this->name,
            'account_title' => $this->account_title,
            'mobile' => $this->mobile,
            'email'=>$this->email,
            'usedCount'=>$this->usedCount,
            'accountBalance'=> ceil((int)$this->account_balance / $this->smsTariff),
            'addMobileToCustomers'=>$this->addMobileToCustomers,
            'created_at'=>Verta($this->created_at)->format('%d %B %Y'),
        ];
    }
}
