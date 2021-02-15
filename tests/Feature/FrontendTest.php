<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FrontendTest extends TestCase
{
    /**
     * @test
     */
    public function mainPage()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSeeText('Blogprawo.pl');

    }

    /**
     * @test
     */
    public function search()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/szukaj', [
            'word' => 'więzienie'
        ]);

        $response->assertStatus(200);
        $response->assertSee('więzienie');

    }


}
