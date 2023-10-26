<?php

namespace App\Http\Resources;


use \Illuminate\Http\Request;

class CountryResource extends BaseResource
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
            'name' => $this->name
        ];
        $this->mini = [
            'name_ar' => $this->getTranslation('name', 'ar', $this->useFallbackLocale()),
            'name_en' => $this->getTranslation('name', 'en', $this->useFallbackLocale()),
            'code' => $this->code,
            'is_active' => $this->is_active,
            'active_status' => $this->active_status,
            'active_class' => $this->active_class,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
        $this->full = [
        ];
        //$this->relationLoaded()
        $this->relations = [
        ];
        return $this->getResource();
    }
}
