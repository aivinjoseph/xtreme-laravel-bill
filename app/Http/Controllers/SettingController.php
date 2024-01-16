<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    function index()
    {
        return Inertia::render('Settings/Index', [
            'settings' => Setting::all()
        ]);
    }

    function store(Request $request)
    {
        if ($request->hasFile('files') || $request->has('images')) {
            $images = [];

            if ($request->hasFile('files'))
            {
                foreach ($request->file('files') as $image) {
                    $images[] = '/storage/' . $image->store('home-images', 'public');
                }
            }
    
            Setting::updateOrCreate(['key' => 'home_images'], ['value' => json_encode(array_merge($request->get('images', []), $images))]);
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    function deleteHomeImage($id)
    {
        $images = json_decode(Setting::where('key', 'home_images')->first()->value);
        unset($images[$id]);
        Setting::updateOrCreate(['key' => 'home_images'], ['value' => json_encode($images)]);

        return redirect()->back()->with('success', 'Home image deleted successfully.');
    }
}
