<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'=> $this->id,
            'isbn'=>$this->isbn,
            'title'=>$this->title,
            'cover'=>url().'/cover/'.$this->cover, // '/cover/' adalah path / folder tempat menyimpan file hasil upload
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at
        ];
    }
}