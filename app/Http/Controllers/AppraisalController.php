<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppraisalRequest;
use App\Models\Appraisal;
use App\Models\CarModel;
use App\Models\Manufacturer;
use App\Models\Transmission;
use App\Models\Trim;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppraisalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Appraisal/Index', [
            'appraisals' => Appraisal::latest()->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Appraisal/Create', [
            'models' => CarModel::all(),
            'makes' => Manufacturer::all(),
            'trims' => Trim::all(),
            'transmissions' => Transmission::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppraisalRequest $request)
    {
        Appraisal::create($request->validated());

        return redirect()->route('home')->banner('Your appraisal request has been sent successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appraisal $appraisal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appraisal $appraisal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appraisal $appraisal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appraisal $appraisal)
    {
        //
    }
}
