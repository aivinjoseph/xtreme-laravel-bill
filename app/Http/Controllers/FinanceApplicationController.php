<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinanceApplicationRequest;
use App\Models\FinanceApplication;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FinanceApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('FinanceApplication/Index', [
            'applications' => FinanceApplication::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('FinanceApplication/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FinanceApplicationRequest $request)
    {
        $financeApplication = FinanceApplication::create($request->validated());

        return redirect()->back()->with('success', 'Your application has been submitted!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FinanceApplication $financeApplication)
    {
        return Inertia::render('FinanceApplication/Show', [
            'application' => $financeApplication
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinanceApplication $financeApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FinanceApplication $financeApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinanceApplication $financeApplication)
    {
        //
    }
}
