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
            'featuredCars' => Car::limit(3)->get(),
            'upcomingCars' => Car::limit(3)->get(),
            'brands' => Manufacturer::withCount('cars')->orderBy('cars_count', 'desc')->get(),
        ]);
    }
}
