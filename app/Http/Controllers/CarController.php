<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\BodyType;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\Door;
use App\Models\Drive;
use App\Models\Feature;
use App\Models\Fuel;
use App\Models\Manufacturer;
use App\Models\TechnicalCondition;
use App\Models\Transmission;
use App\Models\Trim;
use Inertia\Inertia;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Cars/Create', [
            'models' => CarModel::all(),
            'makes' => Manufacturer::all(),
            'colors' => Color::all(),
            'trims' => Trim::all(),
            'drives' => Drive::all(),
            'fuels' => Fuel::all(),
            'bodyTypes' => BodyType::all(),
            'doors' => Door::all(),
            'conditions' => TechnicalCondition::all(),
            'transmissions' => Transmission::all(),
            'features' => Feature::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
        $images = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = '/storage/' . $image->store('/images', 'public');
            }
        }

        Car::create([
            ...$request->validated(),
            'images' => $images
        ]);

        return redirect()->route('cars.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        //
    }
}
