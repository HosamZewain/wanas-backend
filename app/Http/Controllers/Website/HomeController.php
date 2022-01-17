<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Admin\BaseController;
use App\Http\Controllers\Controller;
use App\Repositories\SQL\ContactUsRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


    public function index()
    {
        return view('website.home');
    }

    public function ContactUsStore(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|max:100',
            'subject' => 'required|string|max:100',
            'body' => 'required|string|max:500',
        ]);

        $inputs = $request->all();
        $resource = app(ContactUsRepository::class)->create($inputs);
        if ($resource) {
            return $this->ResponseJsonSuccess(trans('dashboard.created_successfully'), $resource);
        }
        return $this->ResponseJsonError(trans('dashboard.SomeThingWrong'));
    }
}
