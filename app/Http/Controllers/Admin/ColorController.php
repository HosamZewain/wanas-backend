<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SQL\ColorRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ColorController extends BaseController
{

    private $colorRepository;

    public function __construct(ColorRepository $ColorRepository)
    {
        $this->colorRepository = $ColorRepository;
//        $this->middleware(['permission:show_colors'])->only('index');
//        $this->middleware(['permission:create_colors'])->only(['create', 'store']);
//        $this->middleware(['permission:edit_colors'])->only(['edit', 'update']);
//        $this->middleware(['permission:delete_colors'])->only(['destroy']);

    }

    public function index()
    {
        $resources = $this->colorRepository->search([], [], true, true);
        return view('dashboard.colors.index', compact('resources'));
    }

    public function create()
    {
        return view('dashboard.colors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
        ]);

        $inputs = $request->all();
        $resource = $this->colorRepository->create($inputs);
        if ($resource) {
            return $this->ResponseJsonSuccess(trans('dashboard.created_successfully'), $resource);
        }
        return $this->ResponseJsonError(trans('dashboard.SomeThingWrong'));
    }

    public function edit($id)
    {
        $resource = $this->colorRepository->find($id);
        return view('dashboard.colors.edit', compact('resource'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
        ]);
        $inputs = $request->all();
        $resource = $this->colorRepository->find($id);
        $resource->update($inputs);

        if ($resource) {
            return $this->ResponseJsonSuccess(trans('dashboard.updated_successfully'), $resource);
        }
        return $this->ResponseJsonError(trans('dashboard.SomeThingWrong'));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $resource = $this->colorRepository->find($id);
        $resource->delete();

        return $this->ResponseJsonSuccess(trans('dashboard.deleted_successfully'), $resource);
    }
}
