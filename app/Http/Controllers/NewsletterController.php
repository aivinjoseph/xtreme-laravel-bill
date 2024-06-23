<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request) {
        $subscriber = Subscriber::where("email", $request->email)->first();

        if ($subscriber) return redirect()->back();

        Subscriber::create($request->validate([
            'email' => 'required|email'
        ]));

        return redirect()->back();
    }

    public function destroy() {
        $subscriber = Subscriber::where("email", $request->email)->first();

        if (! $subscriber) return redirect()->back();
    }
}
