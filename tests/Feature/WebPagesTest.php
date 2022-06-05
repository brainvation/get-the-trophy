<?php

namespace Tests\Feature;

use Tests\TestCase;

class WebPagesTest extends TestCase
{
    public function testRoutes()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/privacy/');
        $response->assertStatus(200);

        $response = $this->get('/privacy');
        $response->assertStatus(200);
    }
}
