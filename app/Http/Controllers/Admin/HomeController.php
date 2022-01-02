<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\SQL\TripRepository;
use App\Repositories\SQL\UserRepository;
use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{

    private $userRepository;
    private $tripRepository;

    public function __construct(UserRepository $userRepository, TripRepository $tripRepository)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
        $this->tripRepository = $tripRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $trips = $this->tripRepository->search([], ['user', 'user.vehicle'], false, false, false);
        $trips_count = $trips->count();

        $customersFilters['Type'] = User::TYPE_USER;
        $customers = $this->userRepository->search($customersFilters, [], false, false, false);
        $customers_count = $customers->count();
        $active_customers_count = $customers->where('is_verified', true)->count();
        $not_active_customers_count = $customers->where('is_verified',false)->count();
        return view('dashboard.home', compact('customers_count', 'active_customers_count', 'not_active_customers_count', 'trips_count', 'trips'));
    }
}
