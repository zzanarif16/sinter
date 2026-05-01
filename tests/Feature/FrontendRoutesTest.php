<?php

namespace Tests\Feature;

use Tests\TestCase;

class FrontendRoutesTest extends TestCase
{

    public function test_home_page_is_reachable(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Featured Product');
        $response->assertSee('Inspiration');
    }

    public function test_products_page_is_reachable(): void
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertSee('Product');
    }

    public function test_invalid_product_family_returns_404(): void
    {
        $response = $this->get('/products/family/unknown-family');

        $response->assertStatus(404);
    }

    public function test_about_page_is_reachable(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200);
        $response->assertSee('About');
    }
}
