<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicationListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'author' => $this->author->name,
            'title' => $this->title,
            'image' => $this->thumbnail_path,
            'excerpt' => $this->excerpt,
            'category' => $this->category->name
        ];
    }
}
