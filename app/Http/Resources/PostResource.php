<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Id' => $this->id,
            'UserName' => $this->user->name,
            'Title' => $this->title,
            'Body' => $this->body,
            'Pinned' => $this->pinned,
            'Image' => config('app.url') . "/storage" . asset($this->image),
            'CreatedAt' => $this->created_at->format("Y-M-d"),
            'UpdatedAt' => $this->updated_at->format("Y-M-d"),
            'Tags' => TagResource::collection($this->whenLoaded('tags')),
        ];
    }
}
