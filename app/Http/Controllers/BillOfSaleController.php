<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Support\BillOfSaleSettings;
use Inertia\Inertia;
use Inertia\Response;

class BillOfSaleController extends Controller
{
    public function create(Car $car, BillOfSaleSettings $settings): Response
    {
        return Inertia::render('BillOfSale/Edit', [
            'car' => $car,
            'dealer' => $settings->all(),
        ]);
    }
}
