<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTestBookingRequest;
use App\Mail\DriveTestBooked;
use App\Models\Car;
use App\Models\TestBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class TestBookingController extends Controller
{
    public function index() {
        return Inertia::render('TestBooking/Index', [
            'bookings' => TestBooking::latest()->paginate(10)
        ]);
    }

    public function create()
    {
        return Inertia::render('TestBooking/Create', [
            'car_id' => request('car_id'),
            'cars' => Car::available()->get()
        ]);
    }

    public function store(StoreTestBookingRequest $request)
    {
        $validated = $request->validated();

        $testBooking = TestBooking::create($validated);
        
        Mail::to(config('mail.to'))->send(new DriveTestBooked($testBooking));

        return redirect()->route('home')->banner('Your request has been sent successfully. We will contact you as soon as possible');
    }
}
