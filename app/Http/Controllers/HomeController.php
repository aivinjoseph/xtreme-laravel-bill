<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Welcome', [
            'featuredCars' => Car::featured()->latest()->limit(3)->get(),
            'upcomingCars' => Car::upcoming()->latest()->limit(3)->get(),
            'brands' => Manufacturer::withCount('cars')->orderBy('cars_count', 'desc')->get(),
            'stats' => [
                'cars' => Car::count(),
                'sold' => Car::sold()->count(),
                'upcoming' => Car::upcoming()->count(),
            ]
        ]);
    }
}
