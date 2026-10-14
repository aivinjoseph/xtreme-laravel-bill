<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Support\BillOfSaleSettings;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SettingController extends Controller
{
    function index(BillOfSaleSettings $billOfSaleSettings)
    {
        return Inertia::render('Settings/Index', [
            'settings' => Setting::all(),
            'dealerSettings' => $billOfSaleSettings->all(),
            'publicWebsiteUrl' => Setting::where('key', 'public_website_url')->value('value')
                ?: config('window_sticker.public_website_url'),
        ]);
    }

    function store(Request $request)
    {
        $validated = $request->validate([
            'dealer' => ['nullable', 'array'],
            'dealer.name' => ['nullable', 'string', 'max:255'],
            'dealer.address' => ['nullable', 'string', 'max:255'],
            'dealer.phone' => ['nullable', 'string', 'max:50'],
            'dealer.email' => ['nullable', 'email', 'max:255'],
            'dealer.registration_number' => ['nullable', 'string', 'max:100'],
            'dealer.hst_registration_number' => ['nullable', 'string', 'max:100'],
            'dealer.hst_rate' => ['nullable', 'numeric', 'min:0', 'max:1'],
            'public_website_url' => ['nullable', 'url:http,https', 'max:255'],
        ]);

        if (!empty($validated['dealer'])) {
            app(BillOfSaleSettings::class)->save($validated['dealer']);
        }

        if (array_key_exists('public_website_url', $validated)) {
            Setting::updateOrCreate(
                ['key' => 'public_website_url'],
                ['value' => (string) ($validated['public_website_url'] ?? '')]
            );
        }

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
