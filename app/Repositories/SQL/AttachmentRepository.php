<?php

namespace App\Repositories\SQL;

use App\Models\Attachment;
use App\Repositories\Contracts\IAttachmentRepository;
use Illuminate\Http\File;
use Illuminate\Http\Request;

class AttachmentRepository extends AbstractModelRepository implements IAttachmentRepository
{
    public function __construct(Attachment $model)
    {
        parent::__construct($model);
    }


    public function upload(Request $request, $resource, $key, $folder = 'vehicles'): void
    {
        $resource->attachments()->where('key', $key)->delete();
        $image = $request->{$key};
        $path = $image->store($folder, 'public');
        $resource->attachments()->create([
            'attachment_url' => $folder . '/' . basename($path),
            'original_name' => $image->getClientOriginalName(),
            'file_type' => $image->getMimeType(),
            'key' => $key,
            'status' => Attachment::STATUS_UPLOADED
        ]);
    }

    public function specialUpload($image, $resource, $key, $folder = 'vehicles'): void
    {
        $resource->attachments()->where('key', $key)->delete();
      //  $path = $image->store($folder, 'public');
        $resource->attachments()->create([
            'attachment_url' => $image,
            'original_name' => pathinfo($image,PATHINFO_FILENAME ),
            'file_type' =>  pathinfo($image,PATHINFO_EXTENSION ),
            'key' => $key,
            'status' => Attachment::STATUS_UPLOADED
        ]);
    }
}
