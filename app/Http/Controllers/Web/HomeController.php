<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $stores = Store::selectRaw('*,
            (6371 * acos(cos(radians(?)) * cos(radians(latitude))
            * cos(radians(longitude) - radians(?)) + sin(radians(?))
            * sin(radians(latitude)))) AS distance',
            [$latitude, $longitude, $latitude])
            ->get();

        $filteredStores = $stores->filter(function ($store) {
            return $store->distance <= $store->radius;
        })->sortBy('distance');

        return view('web.pages.home.index', compact('filteredStores'));
    }
}
