<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Services\RetailBillOfSalePdf;
use App\Support\BillOfSaleSettings;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
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

    public function pdf(Request $request, Car $car, BillOfSaleSettings $settings, RetailBillOfSalePdf $renderer): HttpResponse
    {
        $validated = $request->validate([
            'data' => ['required', 'array'],
        ]);

        $pdf = $renderer->render($validated['data'], $car, $settings->all());

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="retail-bill-of-sale.pdf"',
            'Cache-Control' => 'no-store, private',
            'Pragma' => 'no-cache',
        ]);
    }
}
