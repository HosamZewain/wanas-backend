<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SQL\CityRepository;
use App\Repositories\SQL\GovernorateRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends BaseController
{

    private $CityRepository;
    private $governorateRepository;

    public function __construct(CityRepository $CityRepository)
    {
        $this->CityRepository = $CityRepository;
        $this->governorateRepository = app(GovernorateRepository::class);
//        $this->middleware(['permission:show_cities'])->only('index');
//        $this->middleware(['permission:create_cities'])->only(['create', 'store']);
//        $this->middleware(['permission:edit_cities'])->only(['edit', 'update']);
//        $this->middleware(['permission:delete_cities'])->only(['destroy']);

    }

    public function index()
    {
        $resources = $this->CityRepository->search(['governorate'], [], true, true);
        return view('dashboard.cities.index', compact('resources'));
    }

    public function create()
    {

        $governorates = $this->governorateRepository->search([], [], false, false, false)->pluck('LName', 'id')->toArray();
        return view('dashboard.cities.create', compact('governorates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'governorates_id' => 'required',
        ]);

        $inputs = $request->all();
        $resource = $this->CityRepository->create($inputs);
        if ($resource) {
            return $this->ResponseJsonSuccess(trans('dashboard.created_successfully'), $resource);
        }
        return $this->ResponseJsonError(trans('dashboard.SomeThingWrong'));
    }

    public function edit($id)
    {
        $resource = $this->CityRepository->find($id);
        $governorates = $this->governorateRepository->search([], [], false, false, false)->pluck('LName', 'id')->toArray();
        return view('dashboard.cities.edit', compact('resource', 'governorates'));
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
        $resource = $this->CityRepository->find($id);
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
        $resource = $this->CityRepository->find($id);
        $resource->delete();

        return $this->ResponseJsonSuccess(trans('dashboard.deleted_successfully'), $resource);
    }
}
