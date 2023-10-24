<?php

namespace App\Http\Resources;


use \Illuminate\Http\Request;

class NotificationResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request) : array
    {
        $this->micro = [
            'id' => $this->id,
            'title' => $this->title,
        ];
        $this->mini = [
            'body' => $this->body,
            'module' => $this->redirect_type,
            'datetime' => $this->updated_at?->diffForHumans(),
        ];
        $this->full = [
            'data' => $this->data,
        ];
        //$this->relationLoaded()
        $this->relations = [
        ];
        return $this->getResource();
    }
}
