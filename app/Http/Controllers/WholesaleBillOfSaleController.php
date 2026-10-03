<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Support\BillOfSaleSettings;
use Inertia\Inertia;
use Inertia\Response;

class WholesaleBillOfSaleController extends Controller
{
    public function create(Car $car, BillOfSaleSettings $settings): Response
    {
        return Inertia::render('WholesaleBillOfSale/Edit', [
            'car' => $car,
            'dealer' => $settings->all(),
        ]);
    }
}
