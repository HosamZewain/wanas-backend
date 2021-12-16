<?php

namespace App\Http\Resources\Api;

use App\Models\Notification;
use App\Models\TripMember;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'to_user' => $this->to_user,
            'from_user' => $this->from_user,
            'type' => $this->type,
            'model_id' => $this->model_id,
            'model_type' => $this->model_type,
            $this->mergeWhen(($this->relatedModel), [
                'relatedModel' => new TripResource($this->relatedModel),
            ]),
            $this->mergeWhen($this->user, [
                'user' => new UserResource($this->user),
            ]),
            $this->mergeWhen((!empty($this->Member)), [
                'member' => new UserResource($this->Member),
            ]),
        ];
    }
}
