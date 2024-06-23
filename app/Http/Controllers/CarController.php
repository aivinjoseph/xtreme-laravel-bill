<?php

namespace App\Http\Controllers;

use App\Events\BidSubmitted;
use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Jobs\SubmitBid;
use App\Mail\CarPosted;
use App\Models\BodyType;
use App\Models\CarModel;
use App\Models\Color;
use App\Models\Door;
use App\Models\Drive;
use App\Models\Feature;
use App\Models\Fuel;
use App\Models\Manufacturer;
use App\Models\Subscriber;
use App\Models\TechnicalCondition;
use App\Models\Transmission;
use App\Models\Trim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
     * Display a listing of the resource.
     */
    public function inventory(Request $request)
    {
        return Inertia::render('Cars/Inventory', [
            'cars' => Car::search($request->except('page'))
                ->orderBy('availability', 'asc')
                ->latest()->paginate(24)->withQueryString(),
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
            'features' => Feature::all(),
            'filters' => $request->all()
        ]);
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
        $car = Car::create($this->getValidatedData($request));

        $subscribers = Subscriber::all()->pluck('email')->toArray();

        Mail::to(config('mail.to'))
            ->bcc($subscribers)
            ->send(new CarPosted($car));

        return redirect()->route('cars.inventory');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return Inertia::render('Cars/Show', [
            'car' => $car
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        return Inertia::render('Cars/Create', [
            'car' => $car,
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
     * Update the specified resource in storage.
     */
    public function update(StoreCarRequest $request, Car $car)
    {
        $car->update($this->getValidatedData($request));

        return redirect()->route('cars.inventory');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car->delete();

        return redirect()->route('cars.inventory');
    }

    public function toggleFeatured(Car $car)
    {
        $car->toggleFeatured();

        return redirect()->route('cars.inventory');
    }

    public function getValidatedData(StoreCarRequest $request) {
        $images = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $image) {
                $images[] = '/storage/' . $image->store('/images', 'public');
            }
        }

        $validated = collect($request->validated())
            ->forget('files')
            ->toArray();
        $validated['images'] = $images;

        if ($request->method() != 'POST') {
            $validated['images'] = array_merge($request->get('images', []), $images);
        }

        $validated['user_id'] = auth()->user()->id;
        
        return $validated;
    }

    function bid(Car $car) {
        BidSubmitted::dispatch($car);

        return $car;
    }
}
