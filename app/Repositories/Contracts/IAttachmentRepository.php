<?php

namespace App\Repositories\Contracts;

use Illuminate\Http\Request;

interface IAttachmentRepository extends IModelRepository
{

    public function upload(Request $request, $resource, $key, $folder = 'vehicles'): void;
}
