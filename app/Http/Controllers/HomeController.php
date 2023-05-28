<?php

namespace App\Http\Controllers;

use App\Repositories\SQL\TripRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var TripRepository
     */
    private $tripRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TripRepository $tripRepository)
    {
        $this->tripRepository = $tripRepository;

        //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return void
     */
    public function test(): void
    {

    }

    /**
     * @param $tripId
     * @return Application|Factory|View|RedirectResponse
     */
    public function share(Request $request)
    {
        $resource = $this->tripRepository->find($request->id, ['user.vehicle', 'members']);
        if ($resource) {
            return view('website.share', compact('resource'));
        }
        return redirect()->to(url('/'));
    }

    public function translate($lang, $text): void
    {

//        $curl = curl_init();
//        curl_setopt_array($curl, [
//            CURLOPT_URL => "https://yandextranslatezakutynskyv1.p.rapidapi.com/translate",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_FOLLOWLOCATION => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "POST",
//            CURLOPT_POSTFIELDS => "apiKey=%3CREQUIRED%3E&lang=en&text=".$text,
//            CURLOPT_HTTPHEADER => [
//                "content-type: application/x-www-form-urlencoded",
//                "x-rapidapi-host: YandexTranslatezakutynskyV1.p.rapidapi.com",
//                "x-rapidapi-key: 9c7dcbe319msh8f720318582c5d3p199375jsn5fc1612004be"
//            ],
//        ]);
//
//        $response = curl_exec($curl);
//        $err = curl_error($curl);
//
//        curl_close($curl);
//
//        if ($err) {
//            echo "cURL Error #:" . $err;
//        } else {
//         dd($response);
//        }
    }

    public function index()
    {
        return view('home');
    }
}
