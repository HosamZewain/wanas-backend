<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SQL\UserVehicleRepository;
use App\Repositories\SQL\VehicleTypeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserVehicleController extends Controller
{
    private $userVehicleRepository;
    private $types;

    public function __construct(UserVehicleRepository $userVehicleRepository, VehicleTypeRepository $vehicleTypeRepository)
    {
        $this->userVehicleRepository = $userVehicleRepository;
        $this->types = $vehicleTypeRepository->search([], [], true, false, false);
    }

    public function index(Request $request)
    {
        $user_id = $request->user_id;
        $filters['UserId'] = $user_id;
        $resources = $this->userVehicleRepository->search($filters, ['VehicleType'], true, true);
        return view('dashboard.user_vehicles.index', compact('resources', 'user_id'));
    }

    public function create(Request $request)
    {
        $user_id = $request->user_id;
        $types = $this->types->pluck('name', 'id')->toArray();

        return view('dashboard.user_vehicles.create', compact('types', 'user_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'color' => 'required|string',
            'number' => 'required|string|unique:user_vehicle,number',
            'model' => 'required|string',
            'type' => 'required|string',
            'image' => 'required|image',
        ]);

        $inputs = $request->all();
        $inputs['user_id'] = $request->user_id;
        $resource = $this->userVehicleRepository->create($inputs);

        if ($request->hasFile('image')) {
            $resource->update(['image' => $request->file('image')->store('vehicles', 'public'),]);
        }
        flash(trans('dashboard.created_successfully'), 'green');

        return redirect()->to(url('admin/user_vehicles?user_id=' . $request->user_id));
    }

    public function edit($id, Request $request)
    {
        $user_id = $request->user_id;
        $types = $this->types->pluck('name', 'id')->toArray();
        $resource = $this->userVehicleRepository->find($id);
        return view('dashboard.user_vehicles.edit', compact('resource', 'types', 'user_id'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function update($id, Request $request)
    {
        $resource = $this->userVehicleRepository->find($id);
        $resource->update($request->all());
        if ($request->hasFile('image')) {
            $resource->update(['image' => $request->file('image')->store('vehicles', 'public'),]);
        }
        flash(trans('dashboard.updated_successfully'), 'success');
        return redirect()->to(url('admin/user_vehicles?user_id=' . $request->user_id));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $resource = $this->userVehicleRepository->find($id);
        $resource->delete();

        return response()->json(['msg' => trans('dashboard.deleted_successfully')], 200);
    }
}
