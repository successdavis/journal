<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'image' => $this->banner_image_path,
            'title' => $this->title,
            'date' => Carbon::parse($this->start_date)->format('d'),    // e.g., "24"
            'day'  => Carbon::parse($this->start_date)->format('D'),    // e.g., "Mon"
            'month'  => Carbon::parse($this->start_date)->format('M'),    // e.g., "Mon"
        ];
    }
}
