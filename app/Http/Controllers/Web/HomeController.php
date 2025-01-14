<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->latitude || !$user->longitude) {
            return back()->withErrors(['error' => 'User location is not available']);
        }

        $latitude = $user->latitude;
        $longitude = $user->longitude;

        // Query stores and calculate the distance
//        $stores = Store::selectRaw('*,
//            (6371 * acos(cos(radians(?)) * cos(radians(latitude))
//            * cos(radians(longitude) - radians(?)) + sin(radians(?))
//            * sin(radians(latitude)))) AS distance',
//            [$latitude, $longitude, $latitude])
//            ->get();

//        $filteredStores = $stores->filter(function ($store) {
//            return $store->distance <= $store->radius;
//        })->sortBy('distance');

        $stores = Store::get();

        $destinations = $stores->map(function ($store) {
            return $store->latitude . ',' . $store->longitude;
        })->join('|');

        $apiKey = 'AIzaSyDEUAvsqd3MEzgO_mj_VwvjqmBfuC0FpTQ';
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json";

        $response = Http::get($url, [
            'origins' => "{$latitude},{$longitude}",
            'destinations' => $destinations,
            'key' => $apiKey,
        ]);

        if ($response->ok()) {
            $data = $response->json();

            if (
                isset($data['rows']) &&
                isset($data['rows'][0]) &&
                isset($data['rows'][0]['elements']) &&
                !empty($data['rows'][0]['elements'])
            ) {
                $distances = collect($data['rows'][0]['elements'])->map(function ($element, $index) use ($stores) {
                    $store = $stores[$index];
//                    dd($element['distance']['value']);

                    $distance = $element['distance']['value'] ;

                    return [
                        'id' => $store->id,
                        'name' => $store->name,
                        'distance' => $distance, // Convert meters to kilometers
                        'radius' => $store->radius,
                        'image_name' => $store->image_name,
                        'address' => $store->address

                    ];

                });

                // Filter and sort stores
                $filteredStores = $distances->filter(function ($store) {
                    return $store['distance'] <= $store['radius'];
                })->sortBy('distance');

                return view('web.pages.home.index', compact('filteredStores'));
            }
        }

        // Google response failure
        $filteredStores = NULL;
        return view('web.pages.home.index', compact('filteredStores'));
    }
}
