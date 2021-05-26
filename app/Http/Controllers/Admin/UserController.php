<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\SQL\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $filters['Type'] = User::TYPE_ADMIN;
        $resources = $this->userRepository->search($filters, [], true, true);
        return view('dashboard.users.index', compact('resources'));
    }

    public function create()
    {
        return view('dashboard.users.create');
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
        $inputs['type'] = User::TYPE_ADMIN;
        $this->userRepository->create($inputs);
        flash(trans('dashboard.created_successfully'), 'green');

        return redirect()->to(route('users.index'));
    }

    public function edit($id)
    {
        $resource = $this->userRepository->find($id);
        return view('dashboard.users.edit', compact('resource'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return RedirectResponse
     */
    public function update($id, Request $request)
    {
        $resource = $this->userRepository->find($id);
        $resource->update($request->all());
        flash(trans('dashboard.updated_successfully'), 'success');
        return redirect()->to(route('users.index'));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $resource = $this->userRepository->find($id);
        $resource->delete();

        return response()->json(['msg' => trans('dashboard.deleted_successfully')], 200);
    }
}
