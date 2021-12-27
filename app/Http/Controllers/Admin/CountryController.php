<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SQL\CountryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CountryController extends BaseController
{
    private $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
//        $this->middleware(['permission:show_countries'])->only('index');
//        $this->middleware(['permission:create_countries'])->only(['create', 'store']);
//        $this->middleware(['permission:edit_countries'])->only(['edit', 'update']);
//        $this->middleware(['permission:delete_countries'])->only(['destroy']);

    }

    public function index()
    {
        $resources = $this->countryRepository->search([], [], true, true);
        return view('dashboard.countries.index', compact('resources'));
    }

    public function create()
    {
        return view('dashboard.countries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'code' => 'required|max:3',
        ]);

        $inputs = $request->all();
        $resource = $this->countryRepository->create($inputs);
        if ($resource) {
            return $this->ResponseJsonSuccess(trans('dashboard.created_successfully'), $resource);
        }
        return $this->ResponseJsonError(trans('dashboard.SomeThingWrong'));
    }

    public function edit($id)
    {
        $resource = $this->countryRepository->find($id);
        return view('dashboard.countries.edit', compact('resource'));
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
        $resource = $this->countryRepository->find($id);
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
        $resource = $this->countryRepository->find($id);
        $resource->delete();

        return $this->ResponseJsonSuccess(trans('dashboard.deleted_successfully'), $resource);
    }
}
