<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SQL\VehicleTypeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    private $vehicleTypeRepository;

    public function __construct(VehicleTypeRepository $vehicleTypeRepository)
    {
        $this->vehicleTypeRepository = $vehicleTypeRepository;
    }

    public function index()
    {
        $resources = $this->vehicleTypeRepository->search([], [], true, true);
        return view('dashboard.vehicles_types.index', compact('resources'));
    }

    public function create()
    {
        return view('dashboard.vehicles_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'logo' => 'nullable|image',
        ]);

        $inputs = $request->all();
        $resource = $this->vehicleTypeRepository->create($inputs);

        if ($request->hasFile('logo')) {
            $resource->update(['logo' => $request->file('logo')->store('vehicles_types', 'public'),]);
        }
        flash(trans('dashboard.created_successfully'), 'green');

        return redirect()->to(route('vehicles_types.index'));
    }

    public function edit($id)
    {
        $resource = $this->vehicleTypeRepository->find($id);
        return view('dashboard.vehicles_types.edit', compact('resource'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function update($id, Request $request)
    {
        $resource = $this->vehicleTypeRepository->find($id);
        $resource->update($request->all());
        if ($request->hasFile('logo')) {
            $resource->update(['logo' => $request->file('logo')->store('vehicles_types', 'public'),]);
        }
        flash(trans('dashboard.updated_successfully'), 'success');
        return redirect()->to(route('vehicles_types.index'));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $resource = $this->vehicleTypeRepository->find($id);
        $resource->delete();

        return response()->json(['msg' => trans('dashboard.deleted_successfully')], 200);
    }
}
