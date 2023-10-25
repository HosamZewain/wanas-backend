<?php

namespace App\Repositories\SQL;

use App\Models\Page;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\Contracts\PageContract;

class PageRepository extends BaseRepository implements PageContract
{
    /**
     * PageRepository constructor.
     * @param Page $model
     */
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes = []): mixed
    {
        $page = parent::create($attributes);
        
        if (isset($attributes['image'])) {

            foreach ($attributes['image'] as $image) {

                saveFileByRelation($page, $image['id'], 'image');
            }
        }

        return $page->refresh();
    }

    public function update(Model $model, array $attributes = []): mixed
    {
        $page = parent::update($model, $attributes);
        
        if (isset($attributes['image'])) {

            $page->image->delete();

            foreach ($attributes['image'] as $image) {

                saveFileByRelation($page, $image['id'], 'image');
            }
        }

        return $page->refresh();
    }

    public function remove(Model $model): mixed
    {
        $model->image->delete();
        parent::remove($model);
        return $model->delete();
    }
}
