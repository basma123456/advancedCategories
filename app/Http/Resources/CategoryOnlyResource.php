<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryOnlyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

                return [
                    'id' => $this->id,
                    'name' => $this->name,
                    'parent' => new CategoryOnlyResource($this->whenLoaded('parent' )),
                    'children' => CategoryOnlyResource::collection($this->whenLoaded('children')),

                ];

    }
}
