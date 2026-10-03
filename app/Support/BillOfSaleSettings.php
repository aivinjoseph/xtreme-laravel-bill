<?php

namespace App\Support;

use App\Models\Setting;

class BillOfSaleSettings
{
    public const KEYS = [
        'name',
        'address',
        'phone',
        'email',
        'registration_number',
        'hst_registration_number',
        'hst_rate',
    ];

    public function all(): array
    {
        $defaults = config('bill_of_sale');
        $values = Setting::whereIn('key', $this->settingKeys())->pluck('value', 'key');

        return [
            'name' => $values->get('bill_of_sale_dealer_name', $defaults['dealer']['name']),
            'address' => $values->get('bill_of_sale_dealer_address', $defaults['dealer']['address']),
            'phone' => $values->get('bill_of_sale_dealer_phone', $defaults['dealer']['phone']),
            'email' => $values->get('bill_of_sale_dealer_email', $defaults['dealer']['email']),
            'registration_number' => $values->get('bill_of_sale_dealer_registration_number', $defaults['dealer']['registration_number']),
            'hst_registration_number' => $values->get('bill_of_sale_hst_registration_number', $defaults['dealer']['hst_registration_number']),
            'hst_rate' => (float) $values->get('bill_of_sale_hst_rate', $defaults['hst_rate']),
        ];
    }

    public function save(array $values): void
    {
        foreach (self::KEYS as $key) {
            if (!array_key_exists($key, $values)) {
                continue;
            }

            Setting::updateOrCreate(
                ['key' => 'bill_of_sale_' . ($key === 'name' ? 'dealer_name' : $key)],
                ['value' => (string) $values[$key]]
            );
        }
    }

    private function settingKeys(): array
    {
        return array_map(
            fn (string $key) => 'bill_of_sale_' . ($key === 'name' ? 'dealer_name' : $key),
            self::KEYS
        );
    }
}
