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

    public function template(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $template = base_path('SUPREME WHOLESALE BILL OF SALE.pdf');

        abort_unless(is_file($template), 404, 'The approved Wholesale Bill of Sale PDF template is missing.');

        return response()->file($template, [
            'Content-Type' => 'application/pdf',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
