<?php

namespace Tests\Feature;

use Tests\TestCase;

class WholesaleBillOfSaleAuthorizationTest extends TestCase
{
    public function test_wholesale_bill_of_sale_route_requires_authentication(): void
    {
        $this->get('/admin/cars/1/wholesale-bill-of-sale')->assertRedirect('/login');
    }
}
