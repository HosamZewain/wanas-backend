<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use \Illuminate\Http\Request;

class ActivityLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'message' => $this->description,
            'action' => $this->getExtraProperty('action'),
            'changes' => $this->getExtraProperty('changes'),
            'module' => $this->subject_type,
            'causer' => $this->relationLoaded('causer') ? new UserResource($this->causer) : null,
            'date' => $this->created_at->format('d M, Y'),
            'time' => $this->created_at->format('H:i'),
            'datetime' => $this->created_at->format('d M, Y H:i'),
            'duration' => $this->created_at->diffForHumans(),
        ];
    }
}
