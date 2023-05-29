<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterClassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [    'id'=>$this->id,
            'name_course'=>$this->name_course,    'content'=>$this->description,
            'begin'=>$this->begin,    'number'=>$this->number,
            'category_id'=>Category::find($this->category_id)->category_name,    'image'=>$this->image
        ];
    }
}
