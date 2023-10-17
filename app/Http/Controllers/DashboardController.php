<?php

namespace App\Http\Controllers;

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
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function masterData()
    {
        return Inertia::render('Admin/MasterData/Index', [
           'tables' => [
                ['name' => 'Manufacturer', 'label' => 'Makes', 'data' => Manufacturer::all()],
                ['name' => 'CarModel', 'label' => 'Models', 'data' => CarModel::all()],
                ['name' => 'Color', 'label' => 'Colors', 'data' => Color::all()],
                ['name' => 'Trim', 'label' => 'Trims', 'data' => Trim::all()],
                ['name' => 'Drive', 'label' => 'Drives', 'data' => Drive::all()],
                ['name' => 'Fuel', 'label' => 'Fuels', 'data' => Fuel::all()],
                ['name' => 'BodyType', 'label' => 'Body Types', 'data' => BodyType::all()],
                ['name' => 'door', 'label' => 'Doors', 'data' => Door::all()],
                ['name' => 'TechnicalCondition', 'label' => 'Conditions', 'data' => TechnicalCondition::all()],
                ['name' => 'Transmission', 'label' => 'Transmissions', 'data' => Transmission::all()],
                ['name' => 'Feature', 'label' => 'Features', 'data' => Feature::all()]
           ]
        ]);
    }

    public function store() 
    {
        $validated = request()->validate([
            'table' => 'required',
            'name' => 'required'
        ]);

        $model = 'App\\Models\\' . $validated['table'];
        $data = [
            'name' => $validated['name']
        ];

        if ($validated['table'] === 'CarModel') {
            request()->validate([
                'manufacturer_id' => 'required',
            ]);

            $data['manufacturer_id'] = request()->get('manufacturer_id');
        }

        $model::create($data);

        return redirect()->back();
    }
}
