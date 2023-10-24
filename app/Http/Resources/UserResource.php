<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $this->micro = [
            'id' => $this->id,
            'name' => $this->name,
        ];

        $this->mini = [
            'email' => $this->email,
            'phone' => $this->phone,
        ];

        $this->full = [
        ];

        $this->relations = [
            'roles' => $this->relationLoaded('roles') && $this->roles ?
                strtolower(implode(' ,', $this->getRoleNames()->toArray())) : '',

            'roles_ids' => $this->relationLoaded('roles') && $this->roles ? $this->getRoleIds() : [],

            'role_id' => $this->relationLoaded('roles')? $this->getLastRoleId() : null,

            'permissions' => $this->relationLoaded('permissions') && $this->permissions ?
                PermissionResource::collection($this->getAllPermissions()) : null,

            'fcm_tokens' => $this->relationLoaded('tokens') ? $this->getDeviceTokens() : null,
            
            'notifications' => $this->relationLoaded('notifications') ?
                NotificationResource::collection($this->notifications()->latest()->limit(5)->get())
                : null,
        ];

        return $this->getResource();
    }

    public function getRoleIds()
    {
        return $this->whenLoaded('roles', function () {
            return $this->roles->sortByDesc('id')->pluck('id')->toArray();
        });
    }

    public function getLastRoleId()
    {
        return $this->whenLoaded('roles', function () {
            return $this->roles->sortByDesc('id')->pluck('id')->first();
        });
    }
}
