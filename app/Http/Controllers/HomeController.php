<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Manufacturer;
use App\Models\Setting;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome', [
            'featuredCars' => Car::featured()->latest()->limit(8)->get(),
            'upcomingCars' => Car::upcoming()->latest()->limit(8)->get(),
            'brands' => Manufacturer::withCount('cars')->orderBy('cars_count', 'desc')
                ->limit(10)->get(),
            'stats' => [
                'cars' => Car::available()->count(),
                'sold' => Car::sold()->count(),
                'upcoming' => Car::upcoming()->count(),
            ],
            'homeImages' => json_decode(Setting::homeImages()->first()->value),
        ]);
    }
}
