<?php

namespace App\Http\Resources;

use App\Models\Profiler\UserAdditionalData;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->first_name,
            'email' => $this->email,
            'user_add' => UserAdditionalData::where('uuid','=',$this->uuid)->first(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
