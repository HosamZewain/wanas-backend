<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            $this->mergeWhen((!in_array($this->key,['car_front','car_back','car_near'])), [
                'attachment_url' => $this->attachment_url,
                'original_name' => $this->original_name,
                'file_type' => $this->file_type,
            ]),
            'full_url' => asset('storage/' . $this->attachment_url),

        ];
    }
}
