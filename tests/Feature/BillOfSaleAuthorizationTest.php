<?php

namespace Tests\Feature;

use Tests\TestCase;

class BillOfSaleAuthorizationTest extends TestCase
{
    public function test_bill_of_sale_routes_require_authenticated_admin_access(): void
    {
        $this->get('/admin/cars/1/bill-of-sale')->assertRedirect('/login');
    }
}
