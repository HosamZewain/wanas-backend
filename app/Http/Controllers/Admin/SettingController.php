<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\SQL\SettingRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $resource = $this->settingRepository->find($id);
        if (!$resource) {
            $resource = $this->settingRepository->create(['app_name' => 'wanas']);
        }
        return view('dashboard.settings.edit', compact('resource'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return Application|Factory|View
     */
    public function update($id, Request $request)
    {
        $resource = $this->settingRepository->find($id);
        $resource->update($request->all());

        if ($request->hasFile('logo')) {
            $resource->update(['logo' => $request->file('logo')->store('settings', 'public'),]);
        }
        flash(trans('dashboard.updated_successfully'), 'success');
        return view('dashboard.settings.edit', compact('resource'));
    }

}
