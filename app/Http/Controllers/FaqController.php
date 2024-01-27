<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Faqs/Index', [
            'faqs' => Faq::all(),
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function adminIndex()
    {
        return Inertia::render('Faqs/AdminList', [
            'faqs' => Faq::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Faqs/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
        ]);

        Faq::create($request->all());

        return redirect()->route('faqs.adminIndex')->banner('FAQ created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        return Inertia::render('Faqs/Create', [
            'faq' => $faq,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => ['required', 'string'],
            'answer' => ['required', 'string'],
        ]);

        $faq->update($request->all());

        return redirect()->route('faqs.adminIndex')->banner('FAQ updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('faqs.adminIndex')->banner('FAQ deleted successfully');
    }
}
