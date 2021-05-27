<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SQL\TripRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TripController extends Controller
{
    private $tripRepository;

    public function __construct(TripRepository $tripRepository)
    {
        $this->tripRepository = $tripRepository;
    }

    public function index()
    {
        $resources = $this->tripRepository->search([], ['user'], true, true);
        return view('dashboard.trips.index', compact('resources'));
    }

    public function create()
    {
        return view('dashboard.trips.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'mobile' => 'required|string',
            'password' => 'required|string|min:4',
            'email' => 'required|string|email|unique:users,email',
        ]);

        $inputs = $request->all();
        $inputs['password'] = Hash::make($request->password);
        $this->tripRepository->create($inputs);
        flash(trans('dashboard.created_successfully'), 'green');

        return redirect()->to(route('trips.index'));
    }

    public function edit($id)
    {
        $resource = $this->tripRepository->find($id);
        return view('dashboard.trips.edit', compact('resource'));
    }

    public function show($id)
    {
        $resource = $this->tripRepository->find($id, ['members', 'user', 'user.vehicle','TripRate']);
        return view('dashboard.trips.show', compact('resource'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function update($id, Request $request)
    {
        $resource = $this->tripRepository->find($id);
        $resource->update($request->all());
        flash(trans('dashboard.updated_successfully'), 'success');
        return redirect()->to(route('trips.index'));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $resource = $this->tripRepository->find($id);
        $resource->delete();
        if (!$resource) {
            return response()->json(['msg' => trans('dashboard.error')], 422);
        }

        return response()->json(['msg' => trans('dashboard.deleted_successfully')], 200);
    }
}
