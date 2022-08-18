<?php

namespace Tests\Feature;

use App\Helpers\StaticVariables;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_add_user_view()
    {
        $response = $this->get('/append-comment');

        $response->assertStatus(200);
    }

    public function test_api_append_user_comment()
    {
        $response = $this->post('/api/update', [
            'id' => 4, 
            'comments' => 'New user update',
            'password' => StaticVariables::STATIC_KEY
        ]);
 
        $response->assertStatus(200);
    }

    public function test_api_invalid_user_id()
    {
        $response = $this->post('/api/update', [
            'id' => "test", 
            'comments' => 'New user update',
            'password' => StaticVariables::STATIC_KEY
        ]);
 
        $response->assertStatus(422);
    }
    public function test_api_invalid_password()
    {
        $response = $this->post('/api/update', [
            'id' => 4, 
            'comments' => 'New user update',
            'password' => '720DF218518FA20FDC52D4DED7ECC043AB'
        ]);
 
        $response->assertStatus(401);
    }
}
